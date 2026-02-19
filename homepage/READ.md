# Feedback Form with MySQL Database

This is a complete feedback form system with PHP and MySQL backend storage.

## Files Included

1. **feedback.html** - The feedback form (frontend)
2. **submit_feedback.php** - PHP script to handle form submission and store data
3. **view_feedback.php** - Admin page to view all feedback submissions
4. **README.md** - Setup instructions (this file)

## Setup Instructions

### Step 1: Install XAMPP or WAMP
- Download and install XAMPP (https://www.apachefriends.org/) or WAMP
- Start Apache and MySQL services from the control panel

### Step 2: Place Files in Web Server Directory
- Copy all files to your web server directory:
  - **XAMPP**: `C:\xampp\htdocs\feedback\`
  - **WAMP**: `C:\wamp64\www\feedback\`
- Make sure your background image `homepage.png` is also in this folder

### Step 3: Configure Database (Automatic)
The PHP script will automatically:
- Create a database named `feedback_db`
- Create a table named `feedback` with the following structure:
  - id (Primary Key, Auto Increment)
  - name (VARCHAR 100)
  - email (VARCHAR 100)
  - category (VARCHAR 50)
  - rating (INT 1)
  - comments (TEXT)
  - file_name (VARCHAR 255)
  - file_path (VARCHAR 255)
  - submission_date (TIMESTAMP)

### Step 4: Set Permissions
- Create an `uploads` folder in the same directory
- Make sure it has write permissions (the PHP script will create it automatically if it doesn't exist)

### Step 5: Access the Application
1. Open your browser and go to:
   - Feedback Form: `http://localhost/feedback/feedback.html`
   - View Submissions: `http://localhost/feedback/view_feedback.php`

## Database Configuration

If you need to change the database credentials, edit these lines in both PHP files:

```php
$servername = "localhost";
$username = "root";        // Change if different
$password = "";            // Change if you set a password
$dbname = "feedback_db";
```

## Features

✅ Responsive feedback form with background image
✅ File upload support (images, PDFs, Word docs, text files)
✅ Automatic database and table creation
✅ Star rating system (1-5)
✅ Form validation
✅ AJAX submission (no page reload)
✅ Admin view to see all submissions
✅ Secure file handling with unique filenames
✅ 10MB file size limit

## Security Notes

⚠️ This is a basic implementation. For production use, consider adding:
- Prepared statements (PDO) instead of real_escape_string
- CSRF token protection
- Input validation and sanitization
- User authentication for admin page
- HTTPS encryption
- Rate limiting
- Better error handling

## Troubleshooting

**Problem**: "Connection failed" error
- **Solution**: Make sure MySQL is running in XAMPP/WAMP control panel

**Problem**: File upload not working
- **Solution**: Check that the `uploads` folder exists and has write permissions

**Problem**: Can't see the database in phpMyAdmin
- **Solution**: Refresh phpMyAdmin or check if MySQL is running

**Problem**: Background image not showing
- **Solution**: Make sure `homepage.png` is in the same folder as `feedback.html`

## Accessing phpMyAdmin

1. Open: `http://localhost/phpmyadmin`
2. Login with:
   - Username: `root`
   - Password: (leave empty by default)
3. Select `feedback_db` from the left sidebar
4. Click on `feedback` table to view entries

## Support

For issues or questions, check:
- XAMPP documentation: https://www.apachefriends.org/docs/
- PHP documentation: https://www.php.net/docs.php
- MySQL documentation: https://dev.mysql.com/doc/
