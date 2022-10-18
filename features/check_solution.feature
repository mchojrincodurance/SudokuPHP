Feature: Solution checking
  In order to test the validity of a given solution
  As a user
  I need to be able to run the checker against a csv file
  Scenario: Invalid solution
    Given there is a file called "invalid.csv", which contains:
        |1|2|3|4|
        |2|1|4|3|
        |3|4|1|2|
        |4|3|2|1|
    When I ask the checker to check the file "invalid.csv"
    Then I should get "The input doesn't comply with Sudoku's rules."

  Scenario: Incomplete solution
    Given there is a file called "incomplete.csv", which contains:
      |1|2|3|4|
      |2|1||3|
      |3||1|2|
      |4|3|2|1|
    When I ask the checker to check the file "incomplete.csv"
    Then I should get "The input doesn't comply with Sudoku's rules."

  Scenario: Correct solution
    Given there is a file called "correct.csv", which contains:
      |1|2|3|4|
      |3|4|1|2|
      |2|3|4|1|
      |4|1|2|3|
    When I ask the checker to check the file "correct.csv"
    Then I should get "The input complies with Sudoku's rules."