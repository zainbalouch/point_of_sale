# Invoices Manager

## Project Setup Guide

### Initial Setup Steps

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd [project-directory]
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   - Copy `.env.example` to `.env`
   - Configure your database settings in `.env`
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

4. **Database Setup**
   ```bash
   php artisan migrate
   ```

5. **Create Super Admin**
   ```bash
   php artisan shield:super-admin
   ```

6. **Generate Permissions**
   ```bash
   php artisan shield:generate --option=permissions --all
   ```

7. **Seed Permissions**
   ```bash
   php artisan db:seed --class=ShieldSeeder
   ```

### Role Configuration

1. **Login as Super Admin**
   - Use the super admin credentials created in the previous step
   - Access the admin panel

2. **Configure Roles in Filament Shield**
   - Navigate to Filament Shield section
   - Add two essential roles:
     - `admin`: For company administrators
     - `point_of_sale`: For POS users
   - Assign appropriate permissions to each role

### Company Setup

1. **Create Company**
   - Go to Administrator->Companies section
   - Click "Add Company"
   - Fill in required company details:
     - Legal name
     - Tax number
     - Contact information
     - Other company details

2. **Create Company Admin**
   - Navigate to Users section
   - Create a new user with admin role
   - Assign the user to the created company
   - Set up login credentials

### Point of Sale Management

1. **Company Admin Actions**
   - Login as company admin
   - Add point of sales:
     - Navigate to POS section
     - Create new POS locations
     - Configure POS settings
   - Add users to point of sales:
     - Create new users
     - Assign POS role
     - Link users to specific POS locations
   - View company statistics:
     - Access company dashboard
     - Monitor overall performance
     - View sales reports
   - Configure Invoice Settings:
     - Access Other Settings section
     - Upload company logo for invoices
     - Customize invoice template:
       - Set default invoice layout
       - Configure invoice numbering format
       - Set default terms and conditions
       - Customize invoice footer
       - Set default tax rates
       - Configure payment terms

2. **POS User Actions**
   - Login as POS user
   - Access POS-specific features:
     - View assigned POS statistics
     - Monitor sales performance
     - Manage POS operations
