Authentication

The security system is configured in app/config/security.yml. 
1) The website are entirely restricted as ROLE_USER:

- in app/config/security.yml 

security:
        #------
        firewalls:
            main:
                pattern: ^/     
                #----------
        
#-> all the site is under this main firewall

        access_control:
            #--------------
            - { path: ^/, roles: ROLE_USER }    
#-> to access you must be registred as ROLE_USER


2)To be a user, a visitor must have an account. To this he must have to created one of it The security must let to pass this form.

- in app/config/security.yml 

security:
        #------
        firewalls:
            main:
                pattern: ^/      
 #->all the site is under this firewall

                #----------
        access_control:
            #--------------
            - { path: ^/users, roles: IS_AUTHENTICATED_ANONYMOUSLY } 
            
#-> Everyone can access to this page '/users',so '/users/create' works too and a visitor can create an account

            #--------------------------------

3) To pass from anonymous to user role you must be authenticated by a form login managed by AppBundle/Controller/SecurityController:loginAction. The security must call and let to pass this form.

- in app/config/security.yml 

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
        
#-> this setting allow visitors to authenticate themselve with a form when they arrive to the homepage

        access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }  
#-> Everyone can access to this form login page

        #----------------------------------

4) Only users with ROLE_ADMIN can to edit the users

- in src/AppBundle/Controller/UserController.php 

class UserController extends Controller
{
    #----------------------
    /**
     * @Route("/users/{id}/edit", name="user_edit")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(User $user, Request $request)
    #--------------------------------
    
#-> only user admin can be able to call this method (* @Security("has_role('ROLE_ADMIN')"))


- in app/Resources/user/list.html.twig 
#--------------------------------
{% if is_granted('ROLE_ADMIN') %}

    Actions
    
#-> The action column don't display its if the user is not an admin

{% endif %}
#---------------------------------
{% if is_granted('ROLE_ADMIN') %}
#-> the link to the edit page don"t display its if the user is not an admin


    Edit
    
{% endif %}
#---------------------------------


5) The users are loaded from the database through the user entity:

- in app/config/security.yml 

providers:
    doctrine:
        entity:
            class: AppBundle:User
            
#-> User entity 

            property: username 
For more explain on the security look at this link
