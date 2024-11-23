// Create a new Illustrator document
var doc = app.documents.add();

// Define parameters for the honeycomb grid
var hexSize = 50; // Size of each hexagon
var numRows = 5; // Number of rows
var numCols = 7; // Number of columns

// Define colors
var fillColor = new CMYKColor();
fillColor.cyan = 0;
fillColor.magenta = 0;
fillColor.yellow = 0;
fillColor.black = 0;

// Loop through rows
for (var row = 0; row < numRows; row++) {
    // Offset for even rows
    var xOffset = row % 2 == 0 ? 0 : hexSize * Math.sqrt(3) / 2;

    // Loop through columns
    for (var col = 0; col < numCols; col++) {
        // Calculate position for the octagon
        var x = col * hexSize * Math.sqrt(3) + xOffset;
        var y = row * 1.5 * hexSize;

        // Create an array of vertices for the octagon
        var vertices = [];
        for (var i = 0; i < 8; i++) {
            var angle = (45 * i) * Math.PI / 180;
            var vertexX = x + hexSize * Math.cos(angle);
            var vertexY = y + hexSize * Math.sin(angle);
            vertices.push([vertexX, vertexY]);
        }

        // Create the octagon shape
        var hexagon = doc.pathItems.add();
        hexagon.setEntirePath(vertices);
        hexagon.closed = true;

        // Set fill color
        hexagon.fillColor = fillColor;
    }
}
