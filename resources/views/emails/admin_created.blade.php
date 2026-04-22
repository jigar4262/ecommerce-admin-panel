<h2>Hello {{ $admin->first_name }}</h2>

<p>Your account has been created.</p>

<p><strong>Email:</strong> {{ $admin->email }}</p>
<p><strong>Password:</strong> {{ $password }}</p>
<p><strong>Role:</strong> {{ $admin->adminGroup->name }}</p>

<p>Please login and change your password.</p>