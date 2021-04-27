import 'package:flutter/material.dart';

class Info extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text('Olá'),
        Text('Tudo Bem'),
        Text(
          DateTime.now().toString(),
        ),
      ],
    );
  }
}
