# EC2 SQL Injection Lab with ModSecurity (OWASP CRS)

## Project Overview

This project demonstrates:

- Deployment of a vulnerable PHP login application on AWS EC2 (Ubuntu)
- MySQL database integration
- Exploitation of SQL Injection vulnerability
- Protection using ModSecurity with OWASP Core Rule Set (CRS)
- Verification of attack detection and blocking

The goal of this lab is to simulate a real-world web application vulnerability and implement Web Application Firewall (WAF) protection.

---

##  Archiecture

Client (Browser)
        │
        ▼
AWS EC2 (Ubuntu 24.04)
        │
        ├── Apache2 Web Server
        ├── PHP Application (page1.php)
        ├── MySQL Database (testdb)
        └── ModSecurity + OWASP CRS

Flow:

1. User sends login request
2. PHP processes SQL query
3. MySQL executes query
4. ModSecurity inspects request before processing
5. Malicious payloads are blocked (HTTP 403)

---

##  Technologies Used

- AWS EC2 (Ubuntu 24.04)
- Apache 2.4
- PHP
- MySQL 8
- ModSecurity 2.9
- OWASP Core Rule Set (CRS 3.3.5)
- Git & GitHub

---

## Vulnerable Code Example

```php
$username = $_POST['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
