# Role-Based Access Control (RBAC) Implementation

## Role Permissions Summary

### Super Admin
- **Access**: All resources, all tenants
- **Permissions**: All permissions (view, create, edit, delete)
- **Navigation**: All menu items visible

### Admin
- **Access**: Own tenant only
- **Permissions**: View, create, edit (no delete)
- **Navigation**: All menu items visible
- **Resources**: Accounts, Contacts, Leads, Deals, Projects, Invoices

### Manager
- **Access**: Own tenant only
- **Permissions**: View and edit only (no create, no delete)
- **Navigation**: All menu items visible (read-only mode)
- **Resources**: Accounts, Contacts, Leads, Deals, Projects, Invoices

### Sales
- **Access**: Own tenant only
- **Permissions**: View, create, edit for Sales resources only
- **Navigation**: Only Sales menu items visible
- **Resources**: Accounts, Contacts, Leads, Deals
- **Hidden**: Projects, Tasks, Invoices

### Delivery
- **Access**: Own tenant only
- **Permissions**: View, create, edit for Delivery resources only
- **Navigation**: Only Delivery menu items visible
- **Resources**: Projects, Tasks
- **Hidden**: Accounts, Contacts, Leads, Deals, Invoices

### Finance
- **Access**: Own tenant only
- **Permissions**: View, create, edit for Finance resources only
- **Navigation**: Only Finance menu items visible
- **Resources**: Invoices
- **Hidden**: Accounts, Contacts, Leads, Deals, Projects, Tasks

## Implementation Details

### Navigation Visibility
Each Resource implements `shouldRegisterNavigation()` to check if user has `view {resource}` permission.

### Action Permissions
- **Create**: Checked via `canCreate()` method
- **Edit**: Checked via `visible()` on EditAction
- **Delete**: Checked via `visible()` on DeleteAction and `canDelete()` in Edit pages

### Pages Visibility
Custom pages (KanbanBoard, OKRDashboard, SystemHealth) check permissions before displaying.

### Widgets Visibility
Widgets check permissions before displaying data.

## Testing

Test each role with the following credentials:

1. **Super Admin**: `admin@trustflow.com` / `password`
2. **Admin**: `admin@test.com` / `admin123`
3. **Manager**: `manager@test.com` / `manager123`
4. **Sales**: `sales@test.com` / `sales123`
5. **Delivery**: `delivery@test.com` / `delivery123`
6. **Finance**: `finance@test.com` / `finance123`

