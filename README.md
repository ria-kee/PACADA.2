# PACADA.2

PACADA is a comprehensive leave and time-off management system designed specifically for the Department of Science and Technology (DOST) Region 1. It is built to streamline the process of tracking and managing employee leave and time-off credits within the organization. The system is divided into three: the Superadmin side, the Admin side, and the Employee side.

## Introduction

Managing employee leave and time-off can be a complex and time-consuming task for organizations. PACADA aims to simplify this process for the Department of Science and Technology (DOST) Region 1 by providing a user-friendly interface for superadmins, admins, and employees.

## Superadmin Side

- Full control and oversight of the system
- Monitor and manage employee leave and time-off credits
- Track employee leave balances and history
- Assign employees as admins
- Add new employees to the system
- Access employee information
- Generate reports
- Monitor the logs of admins

## Admin Side

- Access and view employee leave and time-off credits within their assigned scope
- Track employee leave balances and history
- View their own logs
- Review and approve/deny leave applications from their assigned employees

## Employee Side

- Access and view personal leave and time-off credits
- View their own profile information
- Submit leave applications
- Track the status of leave applications

## Logs

PACADA includes a comprehensive logging system that records all changes and activities within the system. The logs capture important information such as user actions, date and time of the action, and the specific details of the action performed.

The logging system provides a detailed audit trail, allowing superadmins and admins to track and monitor the activities performed by admins and employees within the system. This feature enhances transparency and accountability, ensuring that all actions taken within PACADA are recorded and can be reviewed when needed.

## Session Timeout

For security purposes, PACADA has a session timeout feature set to 15 minutes. This means that if there is no activity within the system for 15 minutes, the session will expire, and users will need to log in again.

## Installation

To install and set up PACADA locally using XAMPP with PHP and MySQL, follow these steps:

1. Download and install XAMPP from the official website: [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html)
2. Clone the PACADA repository into the XAMPP `htdocs` directory. You can do this by running the following command in the XAMPP command prompt or by manually copying the project files:
   ```
   git clone https://github.com/ria-kee/PACADA.2.git
   ```
3. Open XAMPP and start the Apache and MySQL services.
4. Access PHPMyAdmin by opening a web browser and navigating to `http://localhost/phpmyadmin`.
5. Create a new database for PACADA named `pacada`.
6. Import the PACADA database structure by selecting the newly created database in PHPMyAdmin and choosing the "Import" option. Select the SQL file (`pacada.sql`) included in the PACADA project and execute the import.
7. Configure the database connection settings. In the PACADA project, locate the `dbh.inc.php` file in the `includes` folder. Modify the values in the configuration array to match your database credentials.
8. Launch the application by opening a web browser and navigating to `http://localhost/PACADA.2`.

## Usage

Once PACADA is installed and running, users can access the Superadmin, Admin, and Employee sides using their respective credentials.

### Superadmin Side

1. Open a web browser and navigate to the PACADA application.
2. Login using your super-admin credentials.
3. From the super-admin dashboard, you can:
   - Monitor and manage employee leave and time-off credits.
   - Track employee leave balances and history.
   - Generate reports.
   - Assign employees as admins.
   - Access employee information.
   - Add new employees to the system.
   - Monitor the logs of admins.

### Admin Side

1. Open a web browser and navigate to the PACADA application.
2. Login using the administrator credentials.
3. From the administrator dashboard, you can:
   - Monitor and manage employee leave and time-off credits.
   - Track employee leave balances and history.
   - Generate reports on leave utilization.
   - Add new employees to the system.

### Employee Side

1. Open a web browser and navigate to the PACADA application: [http://localhost/PACADA.2/employee-login.php](http://localhost/PACADA.2/employee-login.php).
2. Login using your employee credentials.
3. From the employee dashboard, you can:
   - View your leave and time-off credits.
   - View your leave history and balances.

## Contact

For any questions, suggestions, or feedback, don't hesitate to contact us at [kilobyteservices.ph@gmail.com](mailto:kilobyteservices.ph@gmail.com).

---
