import 'package:flutter/material.dart';
// Widgets
import '../widgets/info.dart';
import '../widgets/info_livros.dart';
import '../widgets/info_capitulos.dart';

class HomePage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Biblios'),
      ),
      body: ListView(
        padding: const EdgeInsets.all(10.00),
        children: [
          // InfoWidget
          Info(),
          // InfoLivrosWidget
          InfoLivros(),
          // InfoCapitulosWidget
          InfoCapitulos()
        ],
      ),
    );
  }
}
