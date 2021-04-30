import 'package:flutter/material.dart';
// Modelo
import '../models/livro_model.dart';
// Providers
import 'package:provider/provider.dart';
import '../provider/livro_provider.dart';

class FormLivro extends StatefulWidget {
  static const route = '/form_livro';

  @override
  _FormLivroState createState() => _FormLivroState();
}

class _FormLivroState extends State<FormLivro> {
  LivroModel _novoLivro = LivroModel();
  // Criando atributos para o formulário
  final _tituloFocus = FocusNode();
  final _formKey = GlobalKey<FormState>();

  // Salvando os dados de um novo livro
  void _salvarLivro() {
    if (_formKey.currentState.validate()) {
      // Processamento da informação
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          backgroundColor: Colors.green.shade400,
          content: Text('Livro salvo com Sucesso'),
        ),
      );
      // Salvando os dados
      _formKey.currentState.save();
      // Notificando o Provider do formulário o arg listen é falso!
      Provider.of<LivroProvider>(context, listen: false).add(_novoLivro);
      // Fechando a tela
      Navigator.of(context).pop();
    }
  }

  @override
  Widget build(BuildContext formLivro) {
    var title = ModalRoute.of(formLivro).settings.arguments;

    return Scaffold(
      appBar: AppBar(
        title: Text(
          title,
        ),
      ),
      body: Form(
        key: _formKey,
        child: Padding(
          padding: const EdgeInsets.all(10.0),
          child: Column(
            children: [
              TextFormField(
                // Definindo valor inicial
                initialValue: _novoLivro.autor,
                onSaved: (value) => _novoLivro.autor = value,
                textInputAction: TextInputAction.next,
                onFieldSubmitted: (value) =>
                    FocusScope.of(formLivro).requestFocus(_tituloFocus),
                decoration: const InputDecoration(
                  icon: Icon(Icons.person),
                  labelText: 'Nome do Autor',
                ),
                validator: (value) {
                  if (value.isEmpty) {
                    return 'Informe o Nome do Autor';
                  }
                  return null;
                },
              ),
              TextFormField(
                // Definindo valor inicial
                initialValue: _novoLivro.titulo,
                onSaved: (value) => _novoLivro.titulo = value,
                focusNode: _tituloFocus,
                decoration: const InputDecoration(
                  icon: Icon(Icons.book),
                  labelText: 'Título do Livro',
                ),
                validator: (value) {
                  if (value.isEmpty) {
                    return 'Informe o Título do Livro';
                  }
                  return null;
                },
              ),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton(
                  onPressed: () => _salvarLivro(),
                  child: Text('Salvar Livro'),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }
}
