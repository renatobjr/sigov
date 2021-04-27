import 'package:flutter/material.dart';

class InfoCapitulos extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(top: 40.0),
      child: SizedBox(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text('Capitulos'),
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
                separatorBuilder: (BuildContext listCapitulos, int index) =>
                    SizedBox(
                      height: 10,
                    ),
                itemCount: 1),
          ],
        ),
      ),
    );
  }
}
