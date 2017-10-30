<H1>Authentication</H1>

The security system is configured in app/config/security.yml.

<h2>1) The website are entirely restricted as ROLE_USER:</h2>

- in app/config/security.yml

<pre>
security:
        #------
        firewalls:
            main:
                pattern: ^/     
                #----------
        <h5>#-> all the site is under this main firewall</h5>
        access_control:
            #--------------
            - { path: ^/, roles: ROLE_USER }    <h5>#-> to access you must be registred as ROLE_USER</h5>
</pre>

<h2>2)To be a user, a visitor must have an account. To this he must have to created one of it
The security must let to pass this form.</h2>

- in app/config/security.yml

<pre>
security:
        #------
        firewalls:
            main:
                pattern: ^/      <h5> #->all the site is under this firewall</h5>
                #----------
        access_control:
            #--------------
            - { path: ^/users, roles: IS_AUTHENTICATED_ANONYMOUSLY } <h5>#-> Everyone can access to this page '/users',so '/users/create' works too and a visitor can create an account</h5>
            #--------------------------------
</pre>

<h2>3) To pass from anonymous to user role you must be authenticated by a form login managed by AppBundle/Controller/SecurityController:loginAction.
The security must call and let to pass this form.</h2>

- in app/config/security.yml

<pre>
security:
        #------
        firewalls:
            main:
                anonymous: ~
                pattern: ^/
                form_login:
                    login_path: login
                    check_path: login_check
                    always_use_default_target_path:  true
                    default_target_path:  /
                logout: ~
        <h5>#-> this setting allow visitors to authenticate themselve with a form when they arrive to the homepage</h5>
        access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }  <h5>#-> Everyone can access to this form login page</h5>
        #----------------------------------
</pre>

<h2>4) Only users with ROLE_ADMIN can to edit the users</h2>

- in src/AppBundle/Controller/UserController.php

<pre>
class UserController extends Controller
{
    #----------------------
    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(User $user, Request $request)
    #--------------------------------
    <h5>#-> only user admin can be able to call this method (* @Security("has_role('ROLE_ADMIN')"))</h5>
</pre>

- in app/Resources/user/list.html.twig

<pre>
#--------------------------------
{% if is_granted('ROLE_ADMIN') %}

    Actions
    <h5>#-> The action column don't display its if the user is not an admin</h5>
{% endif %}
#---------------------------------
{% if is_granted('ROLE_ADMIN') %}
<h5>#-> the link to the edit page don"t display its if the user is not an admin</h5>

    Edit
    
{% endif %}
#---------------------------------
</pre>

<h2>5) The users are loaded from the database through the user entity:</h2>

- in app/config/security.yml

<pre>
providers:
    doctrine:
        entity:
            class: AppBundle:User
            <h5>#-> User entity </h5>
            property: username 
</pre>
