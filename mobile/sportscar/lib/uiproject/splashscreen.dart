import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:sportscar/uiproject/login.dart';

class MySplashScreen extends StatefulWidget {
  const MySplashScreen({super.key});

  @override
  State<MySplashScreen> createState() => _MySplashScreenState();
}

class _MySplashScreenState extends State<MySplashScreen> 
with SingleTickerProviderStateMixin {

  @override
  void initState(){
    super.initState();
    SystemChrome.setEnabledSystemUIMode(SystemUiMode.immersive);

    Future.delayed(Duration(seconds: 7),() {
      Navigator.of(context).pushReplacement(MaterialPageRoute(
        builder: (_)=> LoginPage(),
        ));
    });
  }

  @override
  void dispose() {
    SystemChrome.setEnabledSystemUIMode(SystemUiMode.manual, 
    overlays: SystemUiOverlay.values);
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: double.infinity,
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            colors: [Colors.pink, Colors.pinkAccent],
            begin: Alignment.topRight,
            end: Alignment.bottomLeft,
          ),
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [

            // const Icon(
            //   Icons.edit,
            //   size: 80,
            //   color: Colors.white,
            // ),
            
            Container(
                padding: const EdgeInsets.all(20),
                margin: const EdgeInsets.symmetric(horizontal: 20),
                width: 400,
                
                child: SizedBox(
                  height: 250,
                  child: ClipRRect(
                    borderRadius: BorderRadius.circular(6.0),
                    child: Image.asset(
                      'lib/images/HD-wallpaper-nnissan-gtr.jpg',
                      width: 400,
                      height: 250,
                      fit: BoxFit.cover,
                    ),
                  ),
                ),
                
                // child: Row(
                //   mainAxisAlignment: MainAxisAlignment.center,
                //   children: [
                //     ClipRRect(
                //       borderRadius: BorderRadius.circular(6.0),
                //       child: Image.asset(
                //         'lib/images/block.png',
                //         height: 150,
                //         ),
                //     ),
                //   ],
                // ),
              ),

            const SizedBox(height: 20,),
            const Text(
              'Exotic Car Dealership',
              style: TextStyle(
                fontStyle: FontStyle.italic,
                color: Colors.black,
                fontSize: 32,

              ),
            ),
          ],
        ),
      ),
    );
  }
}