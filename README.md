# Marlon Test Showcase
[![Build Status](https://marlonbe.visualstudio.com/TestShowCase/_apis/build/status/TestShowCase-CI)](https://marlonbe.visualstudio.com/TestShowCase/_build/latest?definitionId=2)

This is a small project with the sole purpose of listing and comparing different testing tools.

### The project
The project consists of a board that participants can add their email address to.
Participants are displayed by their name (extracted from their email addresses, with some extra formatting), and grouped by their company (also extracted from the email).

### The tools
3 different tools are used to test this project:
- PHPSpec (for unit tests) found in [spec](/spec)
- PHPUnit (for both unit- and system tests) found in [tests](/tests)
- Cypress (for end-to-end tests) found in [end_to_end_tests](/end_to_end_tests)
