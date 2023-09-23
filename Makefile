DOCKER_COMPOSE_DEV = docker compose -f docker-compose.yml -f docker-compose.dev.yml


args = `arg="$(filter-out $(firstword $(MAKECMDGOALS)),$(MAKECMDGOALS))" && echo $${arg:-${1}}`

green  = $(shell printf "\e[32;01m$1\e[0m")
yellow = $(shell printf "\e[33;01m$1\e[0m")
red    = $(shell printf "\e[33;31m$1\e[0m")

format = $(shell printf "%-40s %s" "$(call green,make $1)" $2)

comma:= ,

.DEFAULT_GOAL:=help

%:
	@:

help:
	@echo ""
	@echo "$(call yellow,Use the following commands)"
	@echo "$(call red,===============================)"
	@echo "$(call format,start-dev,'Start dev')"
	@echo "$(call format,stop-dev,'Stop dev')"


start-dev: ## Start dev
	$(DOCKER_COMPOSE_DEV) up --build -d
.PHONY: start-dev

stop-dev: ## Stop dev
	$(DOCKER_COMPOSE_DEV) stop
.PHONY: stop-dev
