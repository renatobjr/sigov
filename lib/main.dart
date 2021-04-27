import 'package:flutter/material.dart';
// Screens
import 'screens/home_page.dart';

void main() {
  runApp(Biblios());
}

class Biblios extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Biblios',
      home: HomePage(),
    );
  }
}
