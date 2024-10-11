import 'package:flutter/material.dart';
import 'package:sportscar/components/mybutton.dart';
import 'package:sportscar/components/mytextfield.dart';
import 'package:sportscar/components/squaretile.dart';


class LoginPage extends StatelessWidget {
  LoginPage({super.key});

  final username = TextEditingController();
  final password = TextEditingController();
  
  BuildContext? get context => null;

  

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.grey[300],
      body: SafeArea(
        child: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const SizedBox(height: 40,),

              // const Row(
              //   mainAxisAlignment: MainAxisAlignment.center,
              //   children: [
              //     SquarTile(imagePath: 'lib/images/comp.png'),
              //   ],
              // ),

              Container(
                padding: const EdgeInsets.all(20),
                margin: const EdgeInsets.symmetric(horizontal: 20),
                width: 350,
                
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    ClipRRect(
                      borderRadius: BorderRadius.circular(6.0),
                      child: Image.asset(
                        'lib/images/exotic-car-logo.jpg',
                        height: 150,
                        ),
                    ),
                  ],
                ),
              ),
      
             
              const SizedBox(height: 10,),
              
              Text(
                'Login',
                style: TextStyle(
                  color: Colors.grey[700],
                  fontSize: 32,
                ),
              ),

              const SizedBox(height: 20,),
              
              MyTextField(
                controller: username, 
                hintText: 'Username', 
                obscureText: false,
              ),

              const SizedBox(height: 10,),

              MyTextField(
                controller: password, 
                hintText: 'Password', 
                obscureText: true,
              ),

              const SizedBox(height: 10,),

              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 25.0),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.end,
                  children: [
                    Text(
                      'Forgot Password?',
                      style: TextStyle(color: Colors.grey[600]),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 10,),

              MyButton(
                onTap: () {
                  Navigator.pushReplacementNamed(context, '/root');
                }, 
              ),

              const SizedBox(height: 10,),

              Padding(
                padding: const EdgeInsets.symmetric(horizontal: 25.0),
                child: Row(
                  children: [
                    Expanded(
                      child: Divider(
                        thickness: 0.5,
                        color: Colors.grey[400],
                      ),
                    ),
                
                    Padding(
                      padding: const EdgeInsets.symmetric(horizontal: 10.0),
                      child: Text(
                        'or continue with',
                        style: TextStyle(color: Colors.grey[700]),
                      ),
                    ),
                
                    Expanded(
                      child: Divider(
                        thickness: 0.5,
                        color: Colors.grey[400],
                      ),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 10,),

              const Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  SquarTile(imagePath: 'lib/images/google.png'),
                ],
              ),

              const SizedBox(height: 10,),

              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [

                  Text(
                    'Don\'t have an account?',
                    style: TextStyle(color: Colors.grey[700]),
                    ),
                  const SizedBox(width: 4,),

                  GestureDetector(
                    onTap: () {
                      Navigator.pushNamed(context, '/register');
                    }, 
                    child: const Text(
                      'Register now',
                      style: TextStyle(
                        color: Colors.blue,
                        fontWeight: FontWeight.bold
                      ),
                    ),
                  ),

                ],
              ),

              const SizedBox(height: 40,),

            ],
          ),
        )
      ),
    );
  }
}