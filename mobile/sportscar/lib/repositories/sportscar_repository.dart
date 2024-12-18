import 'package:dio/dio.dart';
import '../models/sportscar.dart';

class SportsCarRepository {
  final Dio _dio = Dio();
  final String _baseUrl = 'http://localhost:8000/api';

  Future<List<SportsCar>> getAllSportsCars() async {
    try {
      final response = await _dio.get('$_baseUrl/api/sportsCars');
      if (response.statusCode == 200) {
        final List<dynamic> data = response.data;
        return data.map((json) => SportsCar.fromJson(json)).toList();
      }
      throw Exception('Failed to load sports cars');
    } catch (e) {
      // For development, return mock data if backend is not ready
      return SportsCar.sportsCarList;
    }
  }

  Future<List<SportsCar>> getSportsCarsByBrand(String brand) async {
    try {
      final response = await _dio.get('$_baseUrl/api/sportsCars/brand/$brand');
      if (response.statusCode == 200) {
        final List<dynamic> data = response.data;
        return data.map((json) => SportsCar.fromJson(json)).toList();
      }
      throw Exception('Failed to load sports cars by brand');
    } catch (e) {
      // For development, filter mock data if backend is not ready
      return SportsCar.sportsCarList
          .where((car) => car.carType == brand)
          .toList();
    }
  }
}
