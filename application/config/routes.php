<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'site';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*
*	Site Routes
*/
$route['home'] = 'site/home_page';
$route['sign-in'] = 'site/sign_in';
$route['sign-out'] = 'site/sign_out';

/*
*	Account
*/
$route['my-account'] = 'site/account/my_account';
$route['banners'] = 'site/account/banners';
$route['summary'] = 'site/account/banners';
$route['banner'] = 'site/account/banner';
$route['banner/(:num)'] = 'site/account/banner/$1';

$route['cards'] = 'site/account/cards';
$route['set-default-card/(:num)'] = 'site/account/set_default_card/$1';

$route['activate-banner/(:any)'] = 'site/account/activate_banner/$1';
$route['deactivate-banner/(:any)'] = 'site/account/deactivate_banner/$1';
$route['banner-activation/(:any)'] = 'site/account/activate_banner2/$1';
$route['banner-deactivation/(:any)'] = 'site/account/deactivate_banner2/$1';
$route['delete-banner/(:num)'] = 'site/account/delete_banner/$1';

$route['subscribe'] = 'site/account/subscribe';
$route['invoices'] = 'site/account/invoices';
$route['add-subscription/(:num)'] = 'site/account/add_subscription/$1';

$route['check-customer/(:num)'] = 'site/account/check_stripe_customer/$1';

$route['clicks'] = 'site/account/clicks';

/*
*	API
*/
$route['generate-banner/(:any)'] = 'site/generate_banner/$1';
$route['administration/contacts'] = 'admin/contacts/show_contacts';

/*
*	Admin Blog Routes
*/
$route['posts'] = 'admin/blog';
$route['blog/posts'] = 'admin/blog';
$route['blog/categories'] = 'admin/blog/categories';
$route['add-post'] = 'admin/blog/add_post';
$route['edit-post/(:num)'] = 'admin/blog/edit_post/$1';
$route['delete-post/(:num)'] = 'admin/blog/delete_post/$1';
$route['activate-post/(:num)'] = 'admin/blog/activate_post/$1';
$route['deactivate-post/(:num)'] = 'admin/blog/deactivate_post/$1';
$route['post-comments/(:num)'] = 'admin/blog/post_comments/$1';
$route['blog/comments/(:num)'] = 'admin/blog/comments/$1';
$route['blog/comments'] = 'admin/blog/comments';
$route['add-comment/(:num)'] = 'admin/blog/add_comment/$1';
$route['delete-comment/(:num)/(:num)'] = 'admin/blog/delete_comment/$1/$2';
$route['activate-comment/(:num)/(:num)'] = 'admin/blog/activate_comment/$1/$2';
$route['deactivate-comment/(:num)/(:num)'] = 'admin/blog/deactivate_comment/$1/$2';
$route['add-blog-category'] = 'admin/blog/add_blog_category';
$route['edit-blog-category/(:num)'] = 'admin/blog/edit_blog_category/$1';
$route['delete-blog-category/(:num)'] = 'admin/blog/delete_blog_category/$1';
$route['activate-blog-category/(:num)'] = 'admin/blog/activate_blog_category/$1';
$route['deactivate-blog-category/(:num)'] = 'admin/blog/deactivate_blog_category/$1';
$route['delete-comment/(:num)'] = 'admin/blog/delete_comment/$1';
$route['activate-comment/(:num)'] = 'admin/blog/activate_comment/$1';
$route['deactivate-comment/(:num)'] = 'admin/blog/deactivate_comment/$1';

/*
*	Login Routes
*/
$route['login-admin'] = 'admin/auth/login_admin';
$route['logout-admin'] = 'admin/auth/logout_admin';

/*
*	Settings Routes
*/
$route['settings'] = 'admin/settings';
$route['dashboard'] = 'admin/dashboard';

/*
*	Users Routes
*/
$route['users/administrators'] = 'admin/users';
$route['users/administrators/(:any)/(:any)/(:num)'] = 'admin/users/index/$1/$2/$3';
$route['add-user'] = 'admin/users/add_user';
$route['edit-user/(:num)'] = 'admin/users/edit_user/$1';
$route['delete-user/(:num)'] = 'admin/users/delete_user/$1';
$route['activate-user/(:num)'] = 'admin/users/activate_user/$1';
$route['deactivate-user/(:num)'] = 'admin/users/deactivate_user/$1';
$route['reset-user-password/(:num)'] = 'admin/users/reset_password/$1';
$route['admin-profile/(:num)'] = 'admin/users/admin_profile/$1';

/*
*	Admin customers Routes
*/
$route['users/customers'] = 'admin/customers/index';
$route['users/customers/(:any)/(:any)/(:num)'] = 'admin/customers/index/$1/$2/$3';
$route['users/customers/(:any)/(:any)'] = 'admin/customers/index/$1/$2';
$route['admin/add-customer'] = 'admin/customers/add_customer';
$route['admin/edit-customer/(:num)'] = 'admin/customers/edit_customer/$1';
$route['admin/edit-customer/(:num)/(:num)'] = 'admin/customers/edit_customer/$1/$2';
$route['admin/delete-customer/(:num)'] = 'admin/customers/delete_customer/$1';
$route['admin/delete-customer/(:num)/(:num)'] = 'admin/customers/delete_customer/$1/$2';
$route['admin/activate-customer/(:num)'] = 'admin/customers/activate_customer/$1';
$route['admin/activate-customer/(:num)/(:num)'] = 'admin/customers/activate_customer/$1/$2';
$route['admin/deactivate-customer/(:num)'] = 'admin/customers/deactivate_customer/$1';
$route['admin/deactivate-customer/(:num)/(:num)'] = 'admin/customers/deactivate_customers/$1/$2';

/*
*	other admin Routes
*/
$route['admin/company-profile'] = 'admin/contacts/show_contacts';

/*
*	administration Routes
*/
$route['administration/a'] = 'admin/sections/index';
$route['administration/sections/(:any)/(:any)/(:num)'] = 'admin/sections/index/$1/$2/$3';
$route['administration/add-section'] = 'admin/sections/add_section';
$route['administration/edit-section/(:num)'] = 'admin/sections/edit_section/$1';
$route['administration/delete-section/(:num)'] = 'admin/sections/delete_section/$1';

/*
*	Accounts Routes
*/
$route['accounts/accounts-receivable'] = 'admin/accounts/accounts_receivable';
$route['accounts/accounts-receivable/(:num)'] = 'admin/accounts/accounts_receivable/$1';
$route['accounts/accounts-receivable/(:any)/(:any)/(:num)'] = 'admin/accounts/accounts_receivable/$1/$2/$3';
$route['accounts/accounts-payable'] = 'admin/accounts/accounts_payable';
$route['accounts/accounts-payable/(:num)'] = 'admin/accounts/accounts_payable/$1';
$route['accounts/accounts-payable/(:any)/(:any)/(:num)'] = 'admin/accounts/accounts_payable/$1/$2/$3';
$route['admin/confirm-payment/(:num)/(:any)/(:any)/(:any)/(:any)'] = 'admin/accounts/confirm_payment/$1/$2/$3/$4/$5';
$route['admin/unconfirm-payment/(:num)/(:any)/(:any)/(:any)/(:any)'] = 'admin/accounts/unconfirm_payment/$1/$2/$3/$4/$5';
$route['admin/receipt-payment/(:num)/(:any)/(:any)/(:any)/(:any)'] = 'admin/accounts/receipt_payment/$1/$2/$3/$4/$5';
$route['admin/search-accounts-receivable'] = 'admin/accounts/search_accounts_receivable';
$route['admin/close-receivable-search'] = 'admin/accounts/close_accounts_receivable_search';
$route['admin/search-accounts-payable'] = 'admin/accounts/search_accounts_payable';
$route['admin/close-payable-search'] = 'admin/accounts/close_accounts_payable_search';
$route['accounts/receipts'] = 'admin/accounts/receipts';
$route['accounts/receipts/(:num)'] = 'admin/accounts/receipts/$1';
$route['accounts/receipts/(:any)/(:any)/(:num)'] = 'admin/accounts/receipts/$1/$2/$3';
$route['admin/search-receipts'] = 'admin/accounts/search_receipts';
$route['admin/close-payable-search'] = 'admin/accounts/close_receipts_search';

/*
*	Admin email Routes
*/
$route['emails'] = 'admin/emails/index';
$route['admin/emails/(:any)/(:any)/(:num)'] = 'admin/emails/index/$1/$2/$3';
$route['admin/emails/(:any)/(:any)'] = 'admin/emails/index/$1/$2';
$route['admin/add-email'] = 'admin/emails/add_email';
$route['admin/edit-email/(:num)'] = 'admin/emails/edit_email/$1';
$route['admin/edit-email/(:num)/(:num)'] = 'admin/emails/edit_email/$1/$2';
$route['admin/delete-email/(:num)'] = 'admin/emails/delete_email/$1';
$route['admin/delete-email/(:num)/(:num)'] = 'admin/emails/delete_email/$1/$2';
$route['admin/activate-email/(:num)'] = 'admin/emails/activate_email/$1';
$route['admin/activate-email/(:num)/(:num)'] = 'admin/emails/activate_email/$1/$2';
$route['admin/deactivate-email/(:num)'] = 'admin/emails/deactivate_email/$1';
$route['admin/deactivate-email/(:num)/(:num)'] = 'admin/emails/deactivate_email/$1/$2';

/*
*	Admin plans Routes
*/
$route['stripe/plans'] = 'admin/plans/index';
$route['stripe/plans/(:any)/(:any)/(:num)'] = 'admin/plans/index/$1/$2/$3';
$route['stripe/plans/(:any)/(:any)'] = 'admin/plans/index/$1/$2';
$route['admin/add-plan'] = 'admin/plans/add_plan';
$route['admin/edit-plan/(:num)'] = 'admin/plans/edit_plan/$1';
$route['admin/edit-plan/(:num)/(:num)'] = 'admin/plans/edit_plan/$1/$2';
$route['admin/delete-plan/(:num)'] = 'admin/plans/delete_plan/$1';
$route['admin/delete-plan/(:num)/(:num)'] = 'admin/plans/delete_plan/$1/$2';
$route['admin/activate-plan/(:num)'] = 'admin/plans/activate_plan/$1';
$route['admin/activate-plan/(:num)/(:num)'] = 'admin/plans/activate_plan/$1/$2';
$route['admin/deactivate-plan/(:num)'] = 'admin/plans/deactivate_plan/$1';
$route['admin/deactivate-plan/(:num)/(:num)'] = 'admin/plans/deactivate_plan/$1/$2';

/*
*	Admin sections Routes
*/
$route['administration/sections'] = 'admin/sections/index';
$route['administration/sections/(:any)/(:any)/(:num)'] = 'admin/sections/index/$1/$2/$3';
$route['administration/add-section'] = 'admin/sections/add_section';
$route['administration/edit-section/(:num)'] = 'admin/sections/edit_section/$1';
$route['administration/edit-section/(:num)/(:num)'] = 'admin/sections/edit_section/$1/$2';
$route['administration/delete-section/(:num)'] = 'admin/sections/delete_section/$1';
$route['administration/delete-section/(:num)/(:num)'] = 'admin/sections/delete_section/$1/$2';
$route['administration/activate-section/(:num)'] = 'admin/sections/activate_section/$1';
$route['administration/activate-section/(:num)/(:num)'] = 'admin/sections/activate_section/$1/$2';
$route['administration/deactivate-section/(:num)'] = 'admin/sections/deactivate_section/$1';
$route['administration/deactivate-section/(:num)/(:num)'] = 'admin/sections/deactivate_section/$1/$2';




/*
*	Blog Routes
*/
$route['blog'] = 'site/blog';
$route['blog/(:num)'] = 'site/blog/index/__/__/$1';//going to different page without any filters
$route['blog/(:any)'] = 'site/blog/view_post/$1';//going to single post page
$route['blog/category/(:any)'] = 'site/blog/index/$1';//category present
$route['blog/category/(:any)/(:num)'] = 'site/blog/index/$1/$2';//category present going to next page
$route['blog/search/(:any)'] = 'site/blog/index/__/$1';//search present
$route['blog/search/(:any)/(:num)'] = 'site/blog/index/__/$1/$2';//search present going to next page