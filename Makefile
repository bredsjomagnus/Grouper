#
#
#

# ------------------------------------------------------------------------
#
# Generel stuff
#

# Detect OS
OS = $(shell uname -s)

# Defaults
ECHO = echo

# Make adjustments based on OS
# http://stackoverflow.com/questions/3466166/how-to-check-if-running-in-cygwin-mac-or-linux/27776822#27776822
ifneq (, $(findstring CYGWIN, $(OS)))
	ECHO = /bin/echo -e
endif

# Colors and helptext
NO_COLOR	= \033[0m
ACTION		= \033[32;01m
OK_COLOR	= \033[32;01m
ERROR_COLOR	= \033[31;01m
WARN_COLOR	= \033[33;01m

# Which makefile am I in?
WHERE-AM-I = $(CURDIR)/$(word $(words $(MAKEFILE_LIST)),$(MAKEFILE_LIST))
THIS_MAKEFILE := $(call WHERE-AM-I)

# Echo some nice helptext based on the target comment
HELPTEXT = $(ECHO) "$(ACTION)--->" `egrep "^\# target: $(1) " $(THIS_MAKEFILE) | sed "s/\# target: $(1)[ ]*-[ ]* / /g"` "$(NO_COLOR)"



# ------------------------------------------------------------------------
#
# Specifics
#

# Add local bin path for test tools
#PATH := "./.bin:./vendor/bin:./node_modules/.bin:$(PATH)"
#SHELL := env PATH=$(PATH) $(SHELL)
BIN     := .bin
PHPUNIT := $(BIN)/phpunit
PHPLOC 	:= $(BIN)/phploc
PHPCS   := $(BIN)/phpcs
PHPCBF  := $(BIN)/phpcbf
PHPMD   := $(BIN)/phpmd
PHPDOC  := $(BIN)/phpdoc
BEHAT   := $(BIN)/behat
SHELLCHECK := $(BIN)/shellcheck
BATS := $(BIN)/bats



# target: help               - Displays help.
.PHONY:  help
help:
	@$(call HELPTEXT,$@)
	@$(ECHO) "Usage:"
	@$(ECHO) " make [target] ..."
	@$(ECHO) "target:"
	@egrep "^# target:" $(THIS_MAKEFILE) | sed 's/# target: / /g'


# target: install               - install composer updates.
.PHONY:  install
install:
	@composer update


# target: prepare               - prepare repo with essentials.
.PHONY:  prepare
prepare:
	@cp public/.env_dummy .env.testing
	@cp public/.env_dummy .env
	@php artisan key:generate

.PHONY: phpdoc
phpdoc:
	@sudo phpdoc


# target: test               	- Run unittest and generate coverage
.PHONY:  test
test:
	@./vendor/bin/phpunit --configuration phpunit.xml
