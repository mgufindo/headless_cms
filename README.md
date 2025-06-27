# Setup Guide

---

This guide provides step-by-step instructions to get the project running on your local machine.

## Prerequisites

Before you begin, ensure you have the following installed:

-   **Git**
-   **Composer**
-   **Node.js** and **npm**
-   **MariaDB** (or a compatible MySQL database)
-   **Redis**

---

## Installation Steps

1.  **Clone the Repository**

    ```bash
    git clone <repository-url>
    ```

    (Replace `<repository-url>` with the actual URL of your Git repository.)

2.  **Navigate to Project Directory**

    ```bash
    cd headless_cms
    ```

3.  **Install PHP Dependencies**

    ```bash
    composer install
    ```

4.  **Install Node.js Dependencies**

    ```bash
    npm install
    ```

5.  **Configure Environment Variables**
    First, copy the example environment file:

    ```bash
    cp .env.example .env
    ```

    Then, open the newly created `.env` file and ensure your **database configuration** (for MariaDB) and **Redis settings** are correct and active.

6.  **Generate Application Key**

    ```bash
    php artisan key:generate
    ```

7.  **Run Migrations**

    ```bash
    php artisan migrate
    ```

    If your database doesn't exist yet, you'll be prompted to create it. Type `yes` and press Enter.

8.  **Seed Database for RBAC**
    This step inserts the necessary permissions for Role-Based Access Control (RBAC):
    ```bash
    php artisan migrate --seed
    ```

---

## Running Locally

9.  **Start Development Servers**
    To run the application locally, execute both commands simultaneously:
    ```bash
    npm run dev & php artisan serve
    ```

---

## Accessing the Application

10. **Login Credentials**
    Once the application is running, you can log in using these default credentials:

    -   **Username:** `admin@example.com`
    -   **Password:** `password`

11. **Postman Collection**
    For API testing, import the **Postman collection** found within the `cms` folder of this project.

---
