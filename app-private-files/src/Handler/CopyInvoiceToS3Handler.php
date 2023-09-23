<?php
declare(strict_types=1);

namespace App\Handler;

use App\Message\CopyInvoiceToS3;
use App\Repository\OrdersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Ripcord\Ripcord as RipcordBase;

#[AsMessageHandler]
class CopyInvoiceToS3Handler
{
    private string $url;
    private string $db;
    private string $username;
    private string $password;

    private $uid = null;
    private $models = null;

    private int $i;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly OrdersRepository $ordersRepository,
        private readonly EntityManagerInterface $em
    ) {
        $this->url = $_ENV["ODOO_URL"];
        $this->db = $_ENV["ODOO_DB"];
        $this->username = $_ENV["ODOO_USERNAME"];
        $this->password = $_ENV["ODOO_PASSWORD"];

        $this->i = 0;
    }

    public function __invoke(CopyInvoiceToS3 $invoice): void
    {
        $incrementId = $invoice->getIncrementId();

        $uid = $this->getUid();
        $models = $this->getModels();

        $models->execute_kw(
            $this->db,
            $uid,
            $this->password,
            'account.move',
            'send_invoice_to_s3',
            ['read'],
            ['invoice_origin' => $incrementId]
        );

        $this->logger->warning('Copy to S3: ' . $incrementId . ' iteration ' . $this->i);

        $order = $this->ordersRepository->findOneBy(['incrementId' => $incrementId]);
        if ($order !== null) {
            $order->setCopied(true);

            $this->em->persist($order);
            $this->em->flush();
        }

        $this->i++;
    }

    private function getUid()
    {
        if ($this->uid !== null) {
            return $this->uid;
        }

        $common = RipcordBase::client("$this->url/xmlrpc/2/common");
        $this->uid = $common->authenticate($this->db, $this->username, $this->password, []);

        return $this->uid;
    }

    private function getModels()
    {
        if ($this->models !== null) {
            return $this->models;
        }

        $this->models = RipcordBase::client("$this->url/xmlrpc/2/object");

        return $this->models;
    }
}