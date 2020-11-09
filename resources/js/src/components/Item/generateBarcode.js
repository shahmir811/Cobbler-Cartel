import { jsPDF } from "jspdf";
import JsBarcode from "jsbarcode";

// convert orderNo to base64Barcode
// convert base64Barcode to PNGImage
// Use PNGImage in pdf downloaded file

const generateAndDownloadBarcodeInPDF = orderNo => {
    let makeBase64Image = convertTextToBase64Barcode(orderNo);

    convertBase64ToPNGImage(makeBase64Image).then(realImage => {
        const doc = new jsPDF("p", "mm", "a4");
        doc.addImage(realImage, "PNG", 10, 10);

        doc.save("item_barcode.pdf");
    });
};

const convertBase64ToPNGImage = url => {
    return new Promise(resolve => {
        let img = new Image();
        img.onload = () => resolve(img);
        img.src = url;
    });
};

const convertTextToBase64Barcode = text => {
    let canvas = document.createElement("canvas");
    JsBarcode(canvas, text, { format: "CODE39" });
    return canvas.toDataURL("image/png");
};

export { generateAndDownloadBarcodeInPDF };
