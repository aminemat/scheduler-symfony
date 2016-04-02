Feature: Scheduling shifts
  In order to manage my work schedule
  As a manager
  I need to be able to schedule a shift for an employee
  
  Scenario: Scheduling a shift for an available employee
    Given cashier "John doe" is available
    When I schedule a shift for "John doe" from "9am" to "5pm"
    Then my schedule should contain 1 shift a shift for "John doe"
