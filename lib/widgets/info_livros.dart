import 'package:flutter/material.dart';
// Screen
import '../screens/form_livro_page.dart';
// Providers
import 'package:provider/provider.dart';
import '../provider/livro_provider.dart';

// Enumerando o modelo para renderização da screen
enum InfoLivrosTipo { grid, list }

class InfoLivros extends StatelessWidget {
  final InfoLivrosTipo mode;
  // Tamanho do Card
  final double card = 150;

  InfoLivros([this.mode]);

  @override
  Widget build(BuildContext infoLivros) {
    return FutureBuilder(
      future: Provider.of<LivroProvider>(infoLivros).get(),
      builder: (_, snapshot) {
        if (snapshot.hasData) {
          if (snapshot.data.length == 0) {
            return Center(
              child: Column(
                children: [
                  Text('Vamos iniciar uma nova leitura?'),
                  ElevatedButton(
                    onPressed: () => Navigator.of(infoLivros)
                        .pushNamed(FormLivro.route, arguments: 'Novo Livro'),
                    child: Text('Adicionar Livro'),
                  )
                ],
              ),
            );
          } else {
            return mode == InfoLivrosTipo.grid
                ? GridLivros(
                    livros: snapshot.data,
                    card: card,
                  )
                : ListLivros(
                    livros: snapshot.data,
                    card: card,
                  );
          }
        } else {
          return LinearProgressIndicator();
        }
      },
    );
  }
}

// Grid para Livros
class GridLivros extends StatelessWidget {
  const GridLivros({
    Key key,
    @required this.livros,
    @required this.card,
  }) : super(key: key);

  final List livros;
  final double card;

  @override
  Widget build(BuildContext gridContext) {
    return GridView.builder(
        gridDelegate:
            const SliverGridDelegateWithFixedCrossAxisCount(crossAxisCount: 2),
        itemCount: livros.length,
        itemBuilder: (BuildContext gridLivros, int index) {
          return Container(
            width: card,
            child: Card(
              child: Padding(
                padding: const EdgeInsets.all(10.0),
                child: Text(livros[index].idLivro.toString()),
              ),
            ),
          );
        });
  }
}

// Lista de livros para a HomePage
class ListLivros extends StatelessWidget {
  const ListLivros({
    Key key,
    @required this.livros,
    @required this.card,
  }) : super(key: key);

  final List livros;
  final double card;

  @override
  Widget build(BuildContext listLivros) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text('Livros'),
        SizedBox(
          height: card,
          child: ListView.separated(
            scrollDirection: Axis.horizontal,
            itemBuilder: (listLivros, index) {
              return Container(
                width: card,
                child: Card(
                  child: Padding(
                    padding: const EdgeInsets.all(10.0),
                    child: Text(
                      livros[index].titulo,
                    ),
                  ),
                ),
              );
            },
            separatorBuilder: (BuildContext listLivros, int index) => SizedBox(
              width: 10,
            ),
            itemCount: livros.length,
          ),
        ),
      ],
    );
  }
}
