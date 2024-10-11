import 'package:flutter/material.dart';
import 'package:sportscar/ui/cart.dart';
import 'package:sportscar/ui/favorite.dart';
import 'package:sportscar/ui/profile.dart';
import 'package:sportscar/ui/root.dart';
import 'package:sportscar/ui/scan.dart';
import 'package:sportscar/uiproject/home.dart';
import 'package:sportscar/uiproject/register.dart';
import 'package:sportscar/uiproject/login.dart';
import 'package:sportscar/uiproject/splashscreen.dart';

void main() {
  runApp(const MainApp());
}

class MainApp extends StatelessWidget {
  const MainApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: const MySplashScreen(),
      routes: {
        '/splash': (context) => const MySplashScreen(),
        '/login': (context) => LoginPage(),
        '/register': (context) => RegisterPage(),
        '/root': (context) =>  const MyRootPage(),
        '/home': (context) => const MyHomePage(),
        '/favorite': (context) =>  const MyFavoritePage(),
        '/cart': (context) =>  const MyCartPage(),
        '/profile': (context) =>  const MyProfilePage(),
        '/scan': (context) =>  const MyScanPage(),
      },
    );
  }
}
