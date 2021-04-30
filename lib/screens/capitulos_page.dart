import 'package:flutter/material.dart';
// Screens
import 'package:biblios/screens/form_capitulos_page..dart';
// Widgets
import '../widgets/app_drawer.dart';
import '../widgets/info_capitulos.dart';
// Providers
import 'package:provider/provider.dart';
import 'package:biblios/provider/livro_provider.dart';

class CapitulosPage extends StatelessWidget {
  static const route = '/capitulos';
  @override
  Widget build(BuildContext capitulosPage) {
    var title = ModalRoute.of(capitulosPage).settings.arguments;
    return Scaffold(
      appBar: AppBar(
        title: Text(
          title,
        ),
        actions: [
          FutureBuilder(
            future: Provider.of<LivroProvider>(capitulosPage).get(),
            builder: (_, snapshot) {
              if (snapshot.hasData && snapshot.data.length >= 1) {
                return Padding(
                  padding: const EdgeInsets.only(right: 20.0),
                  child: GestureDetector(
                    onTap: () => Navigator.of(capitulosPage).pushNamed(
                      FormCapitulo.route,
                      arguments: 'Novo Capitulo',
                    ),
                    child: Icon(Icons.add),
                  ),
                );
              } else {
                return Text('');
              }
            },
          )
        ],
      ),
      drawer: AppDrawer(),
      body: SingleChildScrollView(
        child: InfoCapitulos(InfoCapitulosTipo.info),
      ),
    );
  }
}
