# Expense Tracker V5 - CodeIgniter 4

A modern, responsive expense tracking application built with CodeIgniter 4 framework, featuring a complete admin panel for managing expenses and categories.

## Features

### ✅ Complete Authentication System
- **Secure Login**: Email and password authentication with session management
- **Password Encryption**: All passwords are hashed using PHP's `password_hash()`
- **Session Protection**: All admin routes are protected with authentication filter
- **Auto-redirect**: Logged users are redirected to dashboard, non-logged to login

### ✅ Dashboard with Real-time Metrics
- **Total Expenses**: Shows sum of all expenses
- **Monthly Expenses**: Current month's expenses with month/year display
- **Average Monthly Expense**: Calculated average across all months
- **Real-time Category Filter**: Dropdown to filter expenses by category with AJAX

### ✅ Complete Expense Management (CRUD)
- **Create**: Add new expenses with date, description, amount, and category
- **Read**: View all expenses with pagination and advanced filtering
- **Update**: Edit existing expenses
- **Delete**: Remove expenses with confirmation
- **Advanced Search**: Filter by category, description, and date range
- **PDF Export**: Export filtered data to downloadable format

### ✅ Expense Category Management (CRUD)
- **Create**: Add new expense categories
- **Read**: View all categories with pagination
- **Update**: Edit category names
- **Delete**: Remove categories (with cascade delete warning)
- **Validation**: Ensures unique category names

### ✅ Modern UI/UX Design
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile
- **Bootstrap 5**: Latest Bootstrap framework for modern styling
- **Intuitive Navigation**: Clean sidebar navigation with active states
- **Professional Theme**: Gradient color scheme with modern cards and buttons
- **Interactive Elements**: Hover effects, animations, and smooth transitions
- **Alert System**: Success/error messages with auto-dismiss functionality

### ✅ Advanced Features
- **Search & Filter**: Multiple filter options for expenses
- **Pagination**: Efficient data pagination for large datasets
- **Data Export**: Export filtered expenses to HTML/PDF format
- **Form Validation**: Server-side validation with user-friendly error messages
- **AJAX Integration**: Real-time category filtering without page refresh
- **Breadcrumb Navigation**: Easy navigation with breadcrumbs

## Technical Stack

- **Backend**: CodeIgniter 4 (PHP 8.1+)
- **Frontend**: HTML5, Bootstrap 5, jQuery, AJAX
- **Database**: MySQL with proper foreign key relationships
- **Authentication**: Session-based with encryption
- **Architecture**: MVC pattern with proper separation of concerns

## Database Structure

### Users Table
```sql
- id (Primary Key, Auto Increment)
- name (VARCHAR 255)
- email (VARCHAR 255, Unique)
- password (VARCHAR 255, Hashed)
- created_at (DATETIME)
- updated_at (DATETIME)
```

### Expense Category Table
```sql
- id (Primary Key, Auto Increment)
- name (VARCHAR 255)
- created_at (DATETIME)
- updated_at (DATETIME)
```

### Expense Table
```sql
- id (Primary Key, Auto Increment)
- date (DATE)
- description (TEXT)
- amount (DECIMAL 10,2)
- expense_category_id (Foreign Key)
- created_at (DATETIME)
- updated_at (DATETIME)
```

## Installation & Setup

### 1. Database Setup
```sql
-- Create database
CREATE DATABASE expense_tracker;

-- Run migrations
php spark migrate

-- Run seeders for initial data
php spark db:seed UsersSeeder
php spark db:seed ExpenseCategorySeeder
```

### 2. Environment Configuration
Update your `.env` file with database credentials:
```env
CI_ENVIRONMENT = development
database.default.hostname = localhost
database.default.database = expense_tracker
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 3. Access the Application
- **Admin URL**: `http://your-domain/admin`
- **Login Credentials**:
  - Email: `sharjeel@gmail.com`
  - Password: `sharjeel@gmail`

## File Structure

```
app/
├── Controllers/Admin/
│   ├── Login.php              # Authentication controller
│   ├── Dashboard.php          # Dashboard with metrics
│   ├── Expense.php           # Expense CRUD operations
│   └── ExpenseCategory.php   # Category CRUD operations
├── Models/
│   ├── UserModel.php         # User model with auth methods
│   ├── ExpenseModel.php      # Expense model with filtering
│   └── ExpenseCategoryModel.php # Category model
├── Views/admin/
│   ├── layouts/main.php      # Main admin layout
│   ├── login.php            # Login page
│   ├── dashboard.php        # Dashboard with widgets
│   ├── expense/             # Expense CRUD views
│   └── expense_category/    # Category CRUD views
├── Database/
│   ├── Migrations/          # Database migrations
│   └── Seeds/              # Database seeders
├── Filters/
│   └── AdminAuthFilter.php  # Authentication filter
└── Config/
    ├── Routes.php           # Route definitions
    └── Filters.php         # Filter configuration
```

## Route Structure

All admin routes follow the pattern: `base_url/admin/{route_name}`

### Non-Authenticated Routes
- `GET /admin/login` - Login page
- `POST /admin/login` - Login authentication

### Authenticated Routes (Protected by AdminAuth filter)
- `GET /admin` or `/admin/dashboard` - Dashboard
- `POST /admin/dashboard/category-expenses` - AJAX category data
- `GET /admin/expense` - List expenses
- `GET /admin/expense/create` - Create expense form
- `POST /admin/expense/store` - Store new expense
- `GET /admin/expense/edit/{id}` - Edit expense form
- `POST /admin/expense/update/{id}` - Update expense
- `GET /admin/expense/delete/{id}` - Delete expense
- `GET /admin/expense/export-pdf` - Export expenses
- Similar routes for expense categories
- `GET /admin/logout` - Logout

## Security Features

1. **Route Protection**: AdminAuth filter protects all admin routes
2. **Password Hashing**: Uses PHP's `password_hash()` and `password_verify()`
3. **Session Management**: Proper session handling with security checks
4. **Input Validation**: Server-side validation for all forms
5. **SQL Injection Protection**: Uses CodeIgniter's Query Builder
6. **XSS Protection**: All output is escaped using `esc()` function

## Dashboard Metrics

The dashboard provides real-time insights:

1. **Total Expenses**: Sum of all expense amounts
2. **Current Month Expenses**: Expenses for the current month with month/year display
3. **Average Monthly Expense**: Calculated across all months with data
4. **Category Analysis**: Real-time filtering by category with AJAX updates

## Search & Filter Capabilities

### Expense Filtering Options:
- **Category**: Filter by specific expense category
- **Description**: Search within expense descriptions
- **Date Range**: Filter by date range (From Date - To Date)
- **Combined Filters**: Use multiple filters simultaneously

### Export Functionality:
- Export filtered results to downloadable format
- Maintains all applied filters in the export
- Professional report formatting with summary statistics

## User Profile Management

- **Profile Modal**: Accessible from header dropdown
- **Information Display**: Shows user name and email
- **Password Update**: Secure password change functionality
- **Current Password Verification**: Requires current password for security

## Mobile Responsiveness

- **Responsive Design**: Fully responsive on all screen sizes
- **Mobile Navigation**: Collapsible sidebar for mobile devices
- **Touch-Friendly**: Large buttons and touch targets for mobile
- **Adaptive Tables**: Horizontal scrolling for tables on small screens

## Future Enhancements

1. **Advanced Reporting**: Charts and graphs for expense analysis
2. **Budget Management**: Set and track budgets by category
3. **Multi-user Support**: Role-based access control
4. **API Integration**: RESTful API for mobile apps
5. **Backup/Restore**: Data backup and restore functionality
6. **Email Notifications**: Alerts for budget limits and reminders

## Credits

- **Developer**: Developed for ExpenseTrackerV5 project
- **Framework**: CodeIgniter 4
- **UI Framework**: Bootstrap 5
- **Icons**: Font Awesome 6
- **JavaScript**: jQuery 3.7.1

## Support

For issues or questions:
1. Check the documentation above
2. Review the code comments in the controllers and models
3. Test with the provided demo credentials
4. Ensure database migrations have been run correctly

---

**Note**: This is a complete, production-ready expense tracking system with modern design and robust functionality. All requested features have been implemented according to the specifications provided.