import 'package:biblios/screens/capitulos_page.dart';
import 'package:flutter/material.dart';
// Screens
import '../screens/home_page.dart';
import '../screens/livros_page.dart';

class AppDrawer extends StatelessWidget {
  @override
  Widget build(BuildContext appDrawer) {
    return Drawer(
      elevation: 10,
      child: ListView(
        children: [
          ListTile(
            trailing: Icon(Icons.home),
            title: Text('Home'),
            onTap: () => Navigator.of(appDrawer).pushNamed(HomePage.route),
          ),
          ListTile(
            trailing: Icon(Icons.menu_book_sharp),
            title: Text('Livros'),
            onTap: () => Navigator.of(appDrawer).pushNamed(
              LivrosPage.route,
              arguments: 'Livros',
            ),
          ),
          ListTile(
            trailing: Icon(Icons.book),
            title: Text('Capitulos'),
            onTap: () => Navigator.of(appDrawer).pushNamed(
              CapitulosPage.route,
              arguments: 'Capitulos',
            ),
          )
        ],
      ),
    );
  }
}
