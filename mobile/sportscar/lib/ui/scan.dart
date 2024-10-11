import 'package:flutter/material.dart';

class MyScanPage extends StatelessWidget {
  const MyScanPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      
      appBar: AppBar(
      
        title: const Text('Scan Page'),
        automaticallyImplyLeading: false,
      ),
      body: Center(
        child: ElevatedButton(
          onPressed: () {
            Navigator.pushReplacementNamed(context, '/root');
          }, 
          child: const Text('Go back.')
        ),
      ),
    );
  }
}
