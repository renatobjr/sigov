import 'package:flutter/material.dart';

class InfoLivros extends StatelessWidget {
  final double card = 150;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(top: 40.0),
      child: Column(
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
                        child: Text('Livros'),
                      ),
                    ),
                  );
                },
                separatorBuilder: (BuildContext listLivros, int index) =>
                    SizedBox(
                      width: 10,
                    ),
                itemCount: 1),
          ),
        ],
      ),
    );
  }
}
