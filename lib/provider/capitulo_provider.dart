import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
// Model
import '../models/capitulo_model.dart';

class CapituloProvider with ChangeNotifier {
  // Contador inicial do CapituloModel
  int _idCapitulo = 1;
  List<CapituloModel> _capitulo = [];

  // Métodoo para adição de dados
  void add(CapituloModel c) {
    c.idCapitulo = _idCapitulo++;
    _capitulo.add(c);
    notifyListeners();
  }

  Future<List<CapituloModel>> get() {
    return Future.delayed(
      Duration(seconds: 1),
      () => [..._capitulo],
    );
  }
}
