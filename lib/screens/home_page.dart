import 'package:flutter/material.dart';
// Widgets
import '../widgets/app_drawer.dart';
import '../widgets/info.dart';
import '../widgets/info_livros.dart';
import '../widgets/info_capitulos.dart';

class HomePage extends StatelessWidget {
  static const route = '/';

  @override
  Widget build(BuildContext homePage) {
    // Livros provider
    return Scaffold(
      appBar: AppBar(
        title: Text('Biblios'),
      ),
      drawer: AppDrawer(),
      body: ListView(
        padding: const EdgeInsets.all(10.0),
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
