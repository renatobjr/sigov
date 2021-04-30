import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
// Model
import '../models/livro_model.dart';

class LivroProvider with ChangeNotifier {
  // Contador inicial do LivroModel
  int _idLivro = 1;
  List<LivroModel> _livro = [];

  // Método para adição de dados
  void add(LivroModel l) {
    l.idLivro = _idLivro++;
    _livro.add(l);
    notifyListeners();
  }

  // Retorno dos livros cadastrados utilizando o Future para prever
  // a resposta do BD
  Future<List<LivroModel>> get() {
    return Future.delayed(
      Duration(seconds: 1),
      () => [..._livro],
    );
  }
}
