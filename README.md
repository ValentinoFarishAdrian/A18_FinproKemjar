# Command Injection and Secure JWT Authentication Demo

This project demonstrates two different concepts: Command Injection vulnerability and Secure JWT (JSON Web Token) Authentication. It is designed to show how both security issues work, and how they can be mitigated with proper practices.

## Prerequisites

Before running this project, you need the following:

- **XAMPP**: This project uses PHP and requires a local server. XAMPP is an easy-to-install Apache distribution that includes PHP and MySQL.
  - Download XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).
  
- **Web Browser**: Any modern web browser (e.g., Chrome, Firefox, OperaGX) to access the localhost.

## Setup Instructions

Follow these steps to set up and run the project on your local machine:

### 1. Clone the Repository

Start by cloning the project repository to your local machine:

```bash
git clone https://github.com/ValentinoFarishAdrian/A18_FinproKemjar.git
```

### 2. Install XAMPP

- Download and install XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).
- Open the XAMPP control panel and start the Apache server (you may also need MySQL if your project requires a database, but for this demo, it's not necessary).

### 3. Move the Project Folder to XAMPP's `htdocs`

Once you've cloned the repository, move the project folder to the **`htdocs`** directory within the XAMPP installation folder. The typical path to `htdocs` is:

- **Windows**: `C:\xampp\htdocs\`
- **Mac/Linux**: `/opt/lampp/htdocs/`

You can move the folder manually or use the terminal/command prompt to copy it:

```bash
cp -r <your_project_folder> /path/to/xampp/htdocs/
```

### 4. Access the Project in Your Browser

Now that your project is in the `htdocs` directory, you can access it by opening a web browser and navigating to the following URLs:

- For **Command Injection demo**:  
  `http://127.0.0.1/CommandInjection/index.php`
  ![image](https://github.com/user-attachments/assets/1cb5dfe6-cc14-496c-a21c-3503ada03082)

- For **Secure JWT Authentication demo**:  
  `http://127.0.0.1/SecureJWT/onboarding.php`
  ![image](https://github.com/user-attachments/assets/90e63966-3a55-4ef2-9458-b6f6a29e2ef9)


Make sure that both XAMPP Apache server and your web browser are running. If the page doesn't load, check the XAMPP control panel to see if the Apache server is running.
![image](https://github.com/user-attachments/assets/d052ec9e-9cc6-41e0-bff5-4757da787b69)
