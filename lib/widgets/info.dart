import 'package:flutter/material.dart';
// INTL
import 'package:intl/intl.dart';
import 'package:intl/date_symbol_data_local.dart';

class Info extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    // Inicialização do idioma
    initializeDateFormatting('pt_BR');
    final _diaSemana = DateFormat.EEEE('pt_BR').format(DateTime.now());
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text('Olá'),
        Text('Tudo Bem'),
        Text('Hoje é $_diaSemana, vamos à nossa Leitura!'),
      ],
    );
  }
}
