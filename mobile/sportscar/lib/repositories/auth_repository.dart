import 'package:dio/dio.dart';

class AuthRepository {
  final Dio _dio = Dio();
  final String _baseUrl = 'http://10.0.2.2:8000/api'; // For Android Emulator

  Future<Map<String, dynamic>> login(String username, String password) async {
    try {
      final response = await _dio.post('$_baseUrl/login', data: {
        'username': username,
        'password': password,
      });

      if (response.statusCode == 200) {
        final data = response.data;
        if (data['user']['roleId'] == 0) {
          return {
            'success': true,
            'token': data['token'],
            'user': data['user'],
          };
        } else {
          throw Exception('Unauthorized access');
        }
      }
      throw Exception('Login failed');
    } catch (e) {
      throw Exception('Failed to connect to server: ${e.toString()}');
    }
  }
}
