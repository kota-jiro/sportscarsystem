class SportsCar {
  final int carId;
  final int carPrice;
  final double carRating;
  final String carType;
  final String carName;
  final String carImageURL;
  bool isFavorated;
  final String carDescription;

  SportsCar(
    {
      required this.carId,
      required this.carPrice,
      required this.carRating,
      required this.carType,
      required this.carName,
      required this.carImageURL,
      required this.isFavorated,
      required this.carDescription,
    }
  );

  static List<SportsCar> sportsCarList = [

    SportsCar(
      carId: 0,
      carPrice: 50000,
      carRating: 5.0,
      carType: 'Ferrari',
      carName: 'Ferrari 488 GTB',
      carImageURL: 'lib/images/Ferrari_488_GTB.jpg',
      isFavorated: false,
      carDescription: 'The Ferrari 488 GTB has a 3.9L twin-turbo V8, 661 hp, and a top speed of 330 km/h. It goes from 0 to 100 km/h in 3.0 seconds.',
    ),

    SportsCar(
      carId: 1,
      carPrice: 35000,
      carRating: 5.0,
      carType: 'Porsche',
      carName: 'Porsche 911 Carrera',
      carImageURL: 'lib/images/2015_Porsche_911_Carrera_4S_Coupe.jpg',
      isFavorated: false,
      carDescription: 'The Porsche 911 Carrera has a 3.0L twin-turbo flat-six engine with 379 hp. It accelerates from 0 to 100 km/h in 4.2 seconds and has a top speed of 293 km/h.',
    ),

    SportsCar(
      carId: 2,
      carPrice: 29000,
      carRating: 4.7,
      carType: 'Lamborghini',
      carName: 'Lamborghini Huracan',
      carImageURL: 'lib/images/LAMBO_HURACAN.jpg',
      isFavorated: false,
      carDescription: 'The Lamborghini Huracan has a 5.2L V10 engine with 610 hp. It goes from 0 to 100 km/h in 3.2 seconds and has a top speed of 325 km/h.',
    ),

    SportsCar(
      carId: 3,
      carPrice: 30000,
      carRating: 4.9,
      carType: 'Recommended',
      carName: 'McLaren 720S',
      carImageURL: 'lib/images/McLaren_720S_Orange.jpeg',
      isFavorated: false,
      carDescription: 'The McLaren 720S has a 4.0L twin-turbo V8 engine with 720 hp. It goes from 0 to 100 km/h in 2.9 seconds and has a top speed of 341 km/h.',
    ),

    SportsCar(
      carId: 4,
      carPrice: 32000,
      carRating: 4.8,
      carType: 'Nissan',
      carName: 'Nissan Skyline R34 GT-R',
      carImageURL: 'lib/images/Nissan_Skyline_R34_GT-R_Nür_001.jpg',
      isFavorated: false,
      carDescription: 'The Nissan Skyline R34 GT-R has a 2.6L twin-turbo inline-six with 276 hp, a 0-100 km/h time of 4.9 seconds, and a top speed of 250 km/h.',
    ),

    SportsCar(
      carId: 5,
      carPrice: 40000,
      carRating: 5.0,
      carType: 'Recommended',
      carName: 'Bugatti Chiron',
      carImageURL: 'lib/images/bugatti-chiron.webp',
      isFavorated: false,
      carDescription: 'The Bugatti Chiron has an 8.0L quad-turbo W16 engine with 1,479 hp. It goes from 0 to 100 km/h in 2.4 seconds and has a top speed of 420 km/h.',
    ),
  ];
  
}