import 'package:biblios/provider/capitulo_provider.dart';
import 'package:biblios/screens/capitulos_page.dart';
import 'package:biblios/screens/form_capitulos_page..dart';
import 'package:flutter/material.dart';
// Screens
import 'screens/home_page.dart';
import 'screens/livros_page.dart';
import 'screens/form_livro_page.dart';
// Providers
import 'package:provider/provider.dart';
import 'provider/livro_provider.dart';

void main() {
  runApp(
    // Chamada para a conf dos providers
    MultiProvider(
      providers: [
        ChangeNotifierProvider(
          create: (_) => LivroProvider(),
        ),
        ChangeNotifierProvider(
          create: (_) => CapituloProvider(),
        )
      ],
      child: Biblios(),
    ),
  );
}

class Biblios extends StatelessWidget {
  @override
  Widget build(BuildContext main) {
    return MaterialApp(
      title: 'Biblios',
      routes: {
        HomePage.route: (_) => HomePage(),
        LivrosPage.route: (_) => LivrosPage(),
        CapitulosPage.route: (_) => CapitulosPage(),
        FormLivro.route: (_) => FormLivro(),
        FormCapitulo.route: (_) => FormCapitulo()
      },
    );
  }
}
