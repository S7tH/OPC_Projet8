<H1>Authentication</H1>

The security system is configured in app/config/security.yml.

<h2>1) The website are entirely restricted as ROLE_USER:</h2>

# app/config/security.yml
security:
        #------
        firewalls:
            main:
                pattern: ^/     #-><h3> all the site is under this main firewall</h3>
                #----------
        access_control:
            #--------------
            - { path: ^/, roles: ROLE_USER }    #-><h3> to access you must be registred as ROLE_USER</h3>

<h2>2)To be a user, a visitor must have an account. To this he must have to created one of it
The security must let to pass this form.</h2>

security:
        #------
        firewalls:
            main:
                pattern: ^/     #-> <h3>all the site is under this firewall</h3>
                #----------
        access_control:
            #--------------
            - { path: ^/users, roles: IS_AUTHENTICATED_ANONYMOUSLY } #-> <h3>Everyone can access to this page '/users'</h3>
            #-> <h3>so '/users/create' works too and a visitor can create an account</h3>
            #--------------------------------

<h2>3) To pass from anonymous to user role you must be authenticated by a form login managed by AppBundle/Controller/SecurityController:loginAction.
The security must call and let to pass this form.</h2>

# app/config/security.yml
security:
        #------
        firewalls:
            main:
                anonymous: ~
                pattern: ^/
                form_login: #-> <h3>this setting allow visitors to authenticate themselve with a form when they arrive to the homepage</h3>
                    login_path: login
                    check_path: login_check
                    always_use_default_target_path:  true
                    default_target_path:  /
                logout: ~

        access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY } #-> <h3>Everyone can access to this form login page</h3>
        #----------------------------------


<h2>4) Only users with ROLE_ADMIN can to edit the users</h2>

//src/AppBundle/Controller/UserController.php

class UserController extends Controller
{
    #----------------------
    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @Security("has_role('ROLE_ADMIN')") #-> <h3>only user admin can be able to call this method</h3>
     */
    public function editAction(User $user, Request $request)
    #--------------------------------

//app/Resources/user/list.html.twig

#--------------------------------
{% if is_granted('ROLE_ADMIN') %}
    <th>Actions</th>    #-> <h3>The action column don't display its if the user is not an admin</h3>
{% endif %}
#---------------------------------
{% if is_granted('ROLE_ADMIN') %} #-> <h3>the link to the edit page don"t display its if the user is not an admin</h3>
    <td>
        <a href="{{ path('user_edit', {'id' : user.id}) }}" class="btn btn-success btn-sm">Edit</a>
    </td>
{% endif %}
#---------------------------------


<h2>5) The users are loaded from the database through the user entity:</h2>

# app/config/security.yml
providers:
    doctrine:
        entity:
            class: AppBundle:User   #-> <h3>User entity</h3>
            property: username 