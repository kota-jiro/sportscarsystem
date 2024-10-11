import 'package:flutter/material.dart';
import 'package:sportscar/components/mybutton.dart';
import 'package:sportscar/components/mytextfield.dart';

class RegisterPage extends StatelessWidget {
  RegisterPage({super.key});

  final username = TextEditingController();
  final password = TextEditingController();
  final firstname = TextEditingController();
  final lastname = TextEditingController();

  void signUserUp() {}

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

              Container(
                padding: const EdgeInsets.all(5),
                margin: const EdgeInsets.symmetric(horizontal: 5),
                width: 170,
                decoration: BoxDecoration(
                  border: Border.all(color: Colors.white),
                  borderRadius: BorderRadius.circular(6.0),
                  color: Colors.grey[200],
                  
                ),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Image.asset(
                      'lib/images/pngtree-sport-car-logo-vector-png-image_3416247.jpg',
                      height: 150,
                      ),
                  ],
                ),
              ),

              const SizedBox(height: 10,),

              Text(
                'Register Account',
                style: TextStyle(
                  color: Colors.grey[700],
                  fontSize: 32,
                ),
              ),

              const SizedBox(height: 20,),

              MyTextField(
                controller: firstname, 
                hintText: 'Firstname', 
                obscureText: false,
              ),

              const SizedBox(height: 10,),

              MyTextField(
                controller: lastname, 
                hintText: 'Lastname', 
                obscureText: false,
              ),

              const SizedBox(height: 10,),

              MyTextField(
                controller: username, 
                hintText: 'Username', 
                obscureText: false,
              ),

              const SizedBox(height: 10,),

              MyTextField(
                controller: password, 
                hintText: 'Password', 
                obscureText: false,
              ),

              const SizedBox(height: 20,),

              MyRegisterButton(
                onTap: signUserUp,
              ),

              const SizedBox(height: 10,),

              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  Text(
                    'Already have an account?',
                    style: TextStyle(color: Colors.grey[700]),
                    ),
                  const SizedBox(width: 4,),

                  GestureDetector(
                    onTap: () {
                      Navigator.pushNamed(context, '/login');
                    }, 
                    child: const Text(
                      'Login now',
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
        ),
      ),
    );
  }
}