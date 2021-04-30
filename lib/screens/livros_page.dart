import 'package:flutter/material.dart';
// Screens
import '../screens/form_livro_page.dart';
// Widgets
import '../widgets/app_drawer.dart';
import '../widgets/info_livros.dart';

class LivrosPage extends StatelessWidget {
  static const route = '/livros';

  @override
  Widget build(BuildContext livrosPage) {
    var title = ModalRoute.of(livrosPage).settings.arguments;
    return Scaffold(
      appBar: AppBar(
        title: Text(
          title,
        ),
        actions: [
          Padding(
            padding: const EdgeInsets.only(right: 20.0),
            child: GestureDetector(
              onTap: () => Navigator.of(livrosPage)
                  .pushNamed(FormLivro.route, arguments: 'Novo Livro'),
              child: Icon(Icons.add),
            ),
          ),
        ],
      ),
      drawer: AppDrawer(),
      body: InfoLivros(InfoLivrosTipo.grid),
    );
  }
}
