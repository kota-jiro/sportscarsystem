


class SportsCar {
  final int carId;
  final int carPrice;
  final double carRating;
  final String carType;
  final String carName;
  final String carImageURL;
  bool isFavorated;
  final String carDescription;

  SportsCar({
    required this.carId,
    required this.carPrice,
    required this.carRating,
    required this.carType,
    required this.carName,
    required this.carImageURL,
    required this.isFavorated,
    required this.carDescription,
  });

  factory SportsCar.fromJson(Map<String, dynamic> json) {
    return SportsCar(
      carId: json['carId'],
      carPrice: json['price'],
      carRating: json['rating'].toDouble(),
      carType: json['brand'],
      carName: json['model'],
      carImageURL: json['imageUrl'],
      isFavorated: false,
      carDescription: json['description'],
    );
  }

  static List<SportsCar> sportsCarList = [
    SportsCar(
      carId: 1,
      carName: "Ferrari F8",
      carType: "Ferrari",
      carPrice: 276000,
      carRating: 4.5,
      carImageURL: "assets/images/ferrari_f8.png",
      isFavorated: false,
      carDescription: "The Ferrari F8 Tributo is the new mid-rear-engined sports car",
    ),
    // Add more cars
  ];
}