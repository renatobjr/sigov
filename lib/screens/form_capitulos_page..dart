import 'package:flutter/material.dart';
// Models
import '../models/capitulo_model.dart';
// Providers
import 'package:provider/provider.dart';
import '../provider/capitulo_provider.dart';
import '../provider/livro_provider.dart';

class FormCapitulo extends StatefulWidget {
  static const route = '/form_capitulo';

  @override
  _FormCapituloState createState() => _FormCapituloState();
}

class _FormCapituloState extends State<FormCapitulo> {
  CapituloModel _novoCapitulo = CapituloModel();
  // Criando atributos para o formulário
  final _descricaoFocus = FocusNode();
  final _formKey = GlobalKey<FormState>();

  // DropDown para a escoha dos dias da semana
  List<Map<String, Object>> _dropDiaSemana = [
    {'id': 1, 'diaSemana': 'Segunda-feira'},
    {'id': 2, 'diaSemana': 'Terça-feira'},
    {'id': 3, 'diaSemana': 'Quarta-feira'},
    {'id': 4, 'diaSemana': 'Quinta-feira'},
    {'id': 5, 'diaSemana': 'Sexta-feira'},
    {'id': 6, 'diaSemana': 'Sábado'},
    {'id': 7, 'diaSemana': 'Domingo'},
  ];

  // Salvando os dados de um novo capitulo
  void _salvarCapitulo() {
    print(_novoCapitulo.capitulo);
    if (_formKey.currentState.validate()) {
      // Processamento da Informação
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          backgroundColor: Colors.green.shade400,
          content: Text('Capítulo salvo com sucesso'),
        ),
      );
      // Salvando os dados
      _formKey.currentState.save();
      // Notificando o Provider
      Provider.of<CapituloProvider>(context, listen: false).add(_novoCapitulo);
      // Fechando a tela
      Navigator.of(context).pop();
    }
  }

  @override
  Widget build(BuildContext formCapitulo) {
    var title = ModalRoute.of(formCapitulo).settings.arguments;
    return Scaffold(
      appBar: AppBar(
        title: Text(title),
      ),
      body: Form(
        key: _formKey,
        child: Padding(
          padding: const EdgeInsets.all(10.0),
          child: Column(
            children: [
              FutureBuilder(
                future: Provider.of<LivroProvider>(formCapitulo).get(),
                builder: (_, snapshot) {
                  if (snapshot.hasData) {
                    return DropdownButtonFormField(
                      value: _novoCapitulo.livro.toString(),
                      onSaved: (value) => _novoCapitulo.livro = value,
                      decoration: InputDecoration(
                        icon: Icon(Icons.book),
                      ),
                      hint: Text(
                        'Selecione um livro',
                      ),
                      items: snapshot.data
                          .map<DropdownMenuItem<String>>(
                            (l) => DropdownMenuItem<String>(
                              value: l.idLivro.toString(),
                              child: Text(l.titulo),
                            ),
                          )
                          .toList(),
                      onChanged: (value) {
                        setState(() {
                          value = _novoCapitulo.livro;
                        });
                      },
                      validator: (value) {
                        if (value == null) {
                          return 'Selecione um livro';
                        }
                        return null;
                      },
                    );
                  } else {
                    return LinearProgressIndicator();
                  }
                },
              ),
              TextFormField(
                initialValue: _novoCapitulo.capitulo,
                onSaved: (value) => _novoCapitulo.capitulo = value,
                textInputAction: TextInputAction.next,
                onFieldSubmitted: (value) =>
                    FocusScope.of(formCapitulo).requestFocus(_descricaoFocus),
                decoration: const InputDecoration(
                  icon: Icon(Icons.menu_book_sharp),
                  labelText: 'Capítulo',
                ),
                validator: (value) {
                  if (value.isEmpty) {
                    return 'Informe um capítulo';
                  }
                  return null;
                },
              ),
              TextFormField(
                initialValue: _novoCapitulo.descricao,
                onSaved: (value) => _novoCapitulo.descricao = value,
                focusNode: _descricaoFocus,
                decoration: const InputDecoration(
                  icon: Icon(Icons.text_snippet_outlined),
                  labelText: 'Descrição',
                ),
                validator: (value) {
                  if (value.isEmpty) {
                    return 'Insira uma breve descrição';
                  }
                  return null;
                },
                // Configurando o tamanho do campo da descrição
                maxLength: 200,
                minLines: 1,
                maxLines: 3,
              ),
              DropdownButtonFormField(
                value: _novoCapitulo.diaSemana,
                onSaved: (value) => _novoCapitulo.diaSemana = value,
                decoration: InputDecoration(
                  icon: Icon(Icons.book),
                ),
                hint: Text(
                  'Selecione um dia da semana',
                ),
                items: _dropDiaSemana
                    .map(
                      (e) => DropdownMenuItem(
                        value: e['id'],
                        child: Text(e['diaSemana']),
                      ),
                    )
                    .toList(),
                onChanged: (value) {
                  setState(() {
                    value = _novoCapitulo.diaSemana;
                  });
                },
                validator: (value) {
                  if (value == null) {
                    return 'Selecione um dia da semana';
                  }
                  return null;
                },
              ),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: () => _salvarCapitulo(),
                  child: Text('Salvar Capítulo'),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }
}
