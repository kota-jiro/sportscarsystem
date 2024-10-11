import 'package:flutter/material.dart';
import 'package:sportscar/models/sportscars.dart';

class MyHomePage extends StatefulWidget {
  const MyHomePage({super.key});

  @override
  State <MyHomePage> createState() => _MyHomePageState();
}

class _MyHomePageState extends State<MyHomePage> {
  @override
  Widget build(BuildContext context) {

    int selectedIndex = 0;
    Size size = MediaQuery.of(context).size;

    List<SportsCar> _sportsCarList = SportsCar.sportsCarList;

    List<String> _carTypes = [
      'Recommended',
      'Ferrari',
      'Porsche',
      'Lamborghini',
      'McLaren',
      'Nissan',
      'Bugatti',
    ];

    bool toggleIsFavorated(bool isFavorited){
      return !isFavorited;
    }

    return Scaffold(
      body: SingleChildScrollView(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              padding: const EdgeInsets.only(top: 20),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 16.0,),
                    width: size.width * .9,
                    child: Row(
                      crossAxisAlignment: CrossAxisAlignment.center,
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(Icons.search, color: Colors.black54.withOpacity(.6),),
                        const Expanded(
                          child: TextField(
                          showCursor: false,
                          decoration: InputDecoration(
                            hintText: 'Search SportsCars',
                            border: InputBorder.none,
                            focusedBorder: InputBorder.none,
                          ),
                        )),
                      Icon(Icons.mic, color: Colors.black54.withOpacity(.6),),
                      ],
                    ),
                    decoration: BoxDecoration(
                      color: const Color(0xff296e48).withOpacity(.1),
                      borderRadius: BorderRadius.circular(20),
                    ),
                  ),
                  
                ],
              ),
            ),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 12),
              height: 50,
              width: size.width,
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                itemCount: _carTypes.length,
                itemBuilder: (BuildContext context, int index){
                  return Padding(
                    padding: const EdgeInsets.all(8.0),
                      child: GestureDetector(
                        onTap: (){
                          setState((){
                          selectedIndex = index;
                          });
                        },
                        child: Text(
                          _carTypes[index],
                          style: TextStyle(
                            fontSize: 16.0,
                            fontWeight: selectedIndex == index ? FontWeight.bold : FontWeight.w300,
                            color: selectedIndex == index ? const Color(0xff296e48) : Colors.black54,
                          ),
                        ),
                      ),
                  );
              }),
            ),
            SizedBox(
              height: size.height * .3,
              child: ListView.builder(
                itemCount: _sportsCarList.length,
                  scrollDirection: Axis.horizontal,
                  itemBuilder: (BuildContext context, int index){
                return Container(
                  width: 200,
                  margin: const EdgeInsets.symmetric(horizontal: 10),
                  child: Stack(
                    children: [
                      Positioned(
                        top: 10,
                          right: 20,
                        child: Container(
                          height: 50,
                          width: 50,
                          child: IconButton(
                            onPressed: null, 
                            icon: Icon(_sportsCarList[index].isFavorated == true ? Icons.favorite : Icons.favorite_border),
                            color: const Color(0xff296e48),
                            iconSize: 30,
                          ),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(50),
                          ),
                        ),
                      ),
                      Positioned(
                        left: 50,
                        right: 50,
                        top: 50,
                        bottom: 50,
                        child: Image.asset(_sportsCarList[index].carImageURL),
                      ),
                      Positioned(
                        bottom: 15,
                        left: 20,
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              _sportsCarList[index].carType,
                              style: const TextStyle(
                                color: Colors.white70,
                                fontSize: 16,
                              ),
                            ),
                            Text(
                              _sportsCarList[index].carName,
                              style: const TextStyle(
                                color: Colors.white70,
                                fontSize: 15,
                                fontWeight: FontWeight.bold,

                              ),
                            ),
                          ],
                        ),
                      ),
                      Positioned(
                        bottom: 15,
                        right: 20,
                        child: Container(
                          padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 2),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(20),
                          ),
                          child: Text(r'₱' + _sportsCarList[index].carPrice.toString(),
                            style: TextStyle(
                              color: const Color(0xff296e48),
                              fontSize: 16,
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                  decoration: BoxDecoration(
                    color: const Color(0xff296e48).withOpacity(.8),
                    borderRadius: BorderRadius.circular(20),
                  ),
                );
              }),
            ),
            Container(
              padding: const EdgeInsets.only(left: 16, bottom: 20, top: 20),
              child: const Text(
                'New SportsCars',
                style: TextStyle(
                  fontWeight: FontWeight.bold,
                  fontSize: 18.0,
                ),
              )
            ),
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 12),
              height: size.height * 5,
              child: ListView.builder(
                itemCount: _sportsCarList.length,
                scrollDirection: Axis.vertical,
                physics: const BouncingScrollPhysics(),
                itemBuilder: (BuildContext context, int index){
                  return Container(
                    decoration: BoxDecoration(
                      color: const Color(0xff296e48).withOpacity(.1),
                      borderRadius: BorderRadius.circular(10),
                    ),
                    height: 80.0,
                    padding: const EdgeInsets.only(left: 10, top: 10),
                    margin: const EdgeInsets.only(bottom: 10, top: 10),
                    width: size.width,
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      crossAxisAlignment: CrossAxisAlignment.center,
                      children: [
                        Stack(
                          clipBehavior: Clip.none,
                          children: [
                            Container(
                              width: 60.0,
                              height: 60.0,
                              decoration: BoxDecoration(
                                color: const Color(0xff296e48).withOpacity(.8),
                                shape: BoxShape.circle,
                              ),
                            ),
                            Positioned(
                              bottom: 5,
                              left: 0,
                              right: 0,
                              child: SizedBox(
                                height: 80.0,
                                child: Image.asset(_sportsCarList[index].carImageURL),
                              ),
                            ),
                            Positioned(
                              bottom: 5,
                              left: 80,
                              child: Column(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Text(_sportsCarList[index].carType),
                                  Text(_sportsCarList[index].carName, style: const TextStyle(
                                    fontWeight: FontWeight.bold,
                                    fontSize: 18,
                                    color: Colors.black54,
                                  ),)
                                ],
                              ),
                            ),
                          ],
                        ),
                        Container(
                          padding: const EdgeInsets.only(right: 10),
                          child: Text(r'₱' + _sportsCarList[index].carPrice.toString(), style: const TextStyle(
                            fontWeight: FontWeight.bold,
                            fontSize: 18.0,
                            color: Color(0xff296e48),
                          ),),
                        ),
                      ],
                    ),
                  );
                }
              ),
            ),
          ],
        ),
      ),
    );
  }
}