Documentation
SQL Injection Demonstration & Mitigation using ModSecurity (OWASP CRS) on AWS EC2
1. Introduction

This assignment demonstrates the deployment of a vulnerable web application on AWS EC2 and the mitigation of SQL Injection attacks using ModSecurity Web Application Firewall (WAF) with OWASP Core Rule Set (CRS).

The objective is to:

Deploy a login form vulnerable to SQL Injection

Exploit the vulnerability

Implement ModSecurity WAF

Block the SQL Injection attack

Provide deployment links and documentation

2. Environment Setup
2.1 Infrastructure

Cloud Provider: AWS

Service: EC2

OS: Ubuntu 24.04 LTS

Public IP: 13.235.9.139

Open Ports:

22 (SSH)

80 (HTTP)

2.2 Software Installed
Component	Purpose
Apache2	Web Server
PHP	Backend scripting
MySQL	Database
ModSecurity	Web Application Firewall
OWASP CRS	Security rule set
3. Step-by-Step Implementation
Step 1: Launch EC2 Instance

An Ubuntu 24.04 EC2 instance was launched with HTTP (Port 80) enabled to host the web application.

SSH connection was established using:

ssh -i key.pem ubuntu@13.235.9.139

This allows secure remote access to configure the server.

Step 2: Install Required Packages

The following packages were installed:

sudo apt update
sudo apt install apache2 mysql-server php php-mysql libapache2-mod-security2 -y

Explanation:

Apache serves web content.

PHP executes backend logic.

MySQL stores user records.

ModSecurity provides WAF capability.

Apache service was verified:

sudo systemctl status apache2
Step 3: Database Configuration

MySQL database was configured:

CREATE DATABASE testdb;
USE testdb;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100)
);

INSERT INTO users (username) VALUES ('admin');
INSERT INTO users (username) VALUES ('test');

Explanation:

A simple users table was created to validate login input.

Step 4: Create Vulnerable Login Page (page1.php)

The vulnerable login form was created at:

/var/www/html/page1.php

Core vulnerable code:

$query = "SELECT * FROM users WHERE username = '$username'";

Explanation:

User input is directly inserted into SQL query without sanitization, allowing SQL Injection.

Step 5: SQL Injection Exploitation

The following payload was used:

admin' OR 1=1 --

Result:

Login Successful (Authentication bypass)

Explanation:

The query becomes:

SELECT * FROM users WHERE username = 'admin' OR 1=1 --'

Since 1=1 is always true, the condition succeeds and bypasses authentication.

Deployed link:

http://13.235.9.139/page1.php
Step 6: Install and Enable ModSecurity

ModSecurity module was enabled:

sudo a2enmod security2

Configuration file copied:

sudo cp /etc/modsecurity/modsecurity.conf-recommended \
/etc/modsecurity/modsecurity.conf

WAF enabled by modifying:

SecRuleEngine On
Apache restarted:

sudo systemctl restart apache2

Explanation:

This activates ModSecurity in blocking mode.

Step 7: Install OWASP Core Rule Set

CRS was installed:


OWASP CRS provides predefined rules to detect SQL Injection, XSS, and other attacks.

Step 8: Protected Page (page2.php)

A second login page was created:

/var/www/html/page2.php

Same vulnerable code was used intentionally to demonstrate WAF protection.

Deployed link:

http://13.235.9.139/page2.php
Step 9: SQL Injection on Protected Page

Payload used:

admin' OR 1=1 --

Result:

403 Forbidden

Explanation:

ModSecurity detected SQL Injection using OWASP CRS rule 942100 and blocked the request.

Step 10: Log Verification

Logs were checked using:

sudo tail -f /var/log/apache2/error.log

Log output confirmed:

SQL Injection detected

Rule ID 942100 triggered

Inbound anomaly score exceeded

Access denied with code 403

4. Results Summary

Test Case	Result
SQL Injection on page1	Successful
SQL Injection on page2	Blocked (403)
WAF Logs Generated	Yes
Apache Running	Yes
OWASP CRS Enabled	Yes

5. Security Analysis

5.1 Vulnerability Root Cause

Direct inclusion of unsanitized user input into SQL query.

5.2 Mitigation Approach

Defense-in-depth using:

Web Application Firewall (ModSecurity)

OWASP Core Rule Set

Anomaly-based detection

5.3 Recommended Secure Coding Fix

Use prepared statements:

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

Prepared statements eliminate SQL Injection risk at application level.

6. Conclusion

This assignment successfully demonstrates:

Deployment of vulnerable application

Exploitation of SQL Injection

Implementation of WAF

Attack detection and blocking

Log verification

Cloud-based deployment

The project reflects practical Application Security and DevSecOps implementation in a real-world scenario.

7. Submission Links

Exploitable:

http://13.235.9.139/page1.php

Protected:

http://13.235.9.139/page2.php

GitHub Repository:

https://github.com/hareshbabukoramutla0107-code/ec2-sql-injection-lab
This confirms proper mitigation.


