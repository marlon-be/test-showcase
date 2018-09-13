#!/usr/bin/env bash

echo "Clearing database"
bin/console board:clear-participants

cd end_to_end_tests && node_modules/cypress/bin/cypress run --headed
