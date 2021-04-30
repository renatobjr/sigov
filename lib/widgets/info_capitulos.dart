import 'package:flutter/material.dart';
// Providers
import 'package:provider/provider.dart';
import '../provider/capitulo_provider.dart';

enum InfoCapitulosTipo { home, info }

class InfoCapitulos extends StatelessWidget {
  final InfoCapitulosTipo mode;

  InfoCapitulos([this.mode]);
  @override
  Widget build(BuildContext infoCapitulos) {
    return FutureBuilder(
      future: Provider.of<CapituloProvider>(infoCapitulos).get(),
      builder: (listCapitulos, snapshot) {
        if (snapshot.hasData) {
          if (snapshot.data.length >= 1) {
            return SizedBox(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  mode == InfoCapitulosTipo.info ? Text('') : Text('Capítulos'),
                  ListView.separated(
                      shrinkWrap: true,
                      physics: NeverScrollableScrollPhysics(),
                      itemBuilder: (listCapitulos, index) {
                        return Container(
                          height: 100,
                          child: Card(
                            child: Padding(
                              padding: const EdgeInsets.all(10.0),
                              child: Text('Capitulos $index'),
                            ),
                          ),
                        );
                      },
                      separatorBuilder:
                          (BuildContext listCapitulos, int index) => SizedBox(
                                height: 10,
                              ),
                      itemCount: 1),
                ],
              ),
            );
          } else {
            return Text(
                'Seus Capitulos cadastrados aparecem aqui. Mas tente cadastrar um Livro antes!');
          }
        } else {
          return LinearProgressIndicator();
        }
      },
    );
  }
}
