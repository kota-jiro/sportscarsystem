import 'package:animated_bottom_navigation_bar/animated_bottom_navigation_bar.dart';
import 'package:flutter/material.dart';
import 'package:page_transition/page_transition.dart';
import 'package:sportscar/ui/cart.dart';
import 'package:sportscar/ui/favorite.dart';
import 'package:sportscar/ui/profile.dart';
import 'package:sportscar/ui/scan.dart';
import 'package:sportscar/uiproject/home.dart';


class MyRootPage extends StatefulWidget {
  const MyRootPage({super.key});

  @override
  State<MyRootPage> createState() => _MyRootPageState();
}

class _MyRootPageState extends State<MyRootPage> {

  int bottomNavIndex = 0;

  List<Widget> pages = const [
    MyHomePage(),
    MyFavoritePage(),
    MyCartPage(),
    MyProfilePage(),
  ];

  List<IconData> iconList = [
    Icons.home,
    Icons.favorite,
    Icons.shopping_cart,
    Icons.person,
  ];

  List<String> titleList = [
    'Home',
    'Favorite',
    'Cart',
    'Profile'
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Text(
              titleList[bottomNavIndex],
              style: const TextStyle(
                color: Colors.black54,
                fontWeight: FontWeight.w500,
                fontSize: 24,
              ),
            ),
            const Icon(
              Icons.notifications,
              color: Colors.black54,
              size: 30.0
            ),
          ],
        ),
        backgroundColor: Theme.of(context).scaffoldBackgroundColor,
        elevation: 0.0,
      ),

      body: IndexedStack(
        index: bottomNavIndex,
        children: pages,
      ),

      floatingActionButton: FloatingActionButton(
        onPressed: () {
          Navigator.push(context, PageTransition(child: const MyScanPage(), type: PageTransitionType.bottomToTop));
        },
        backgroundColor: const Color(0xff296e48),
        child: Image.asset(
          'lib/images/code-scan.png',
          color: Colors.white,
          height: 30.0,
        ),
      ),

      floatingActionButtonLocation: FloatingActionButtonLocation.centerDocked,

      bottomNavigationBar: AnimatedBottomNavigationBar(
        splashColor: const Color(0xff296e48),
        activeColor: const Color(0xff296e48),
        inactiveColor: Colors.black.withOpacity(.5),
        icons: iconList, 
        activeIndex: bottomNavIndex, 
        gapLocation: GapLocation.center,
        notchSmoothness: NotchSmoothness.softEdge,
        onTap: (index){
          setState(() {
            bottomNavIndex = index;
          });
        },
      ),
    );
  }
}
