import { jsPDF } from "jspdf";
import JsBarcode from "jsbarcode";

// make an array and gather all realImages and there position on PDF
// convert orderNo to base64Barcode
// convert base64Barcode to PNGImage
// Use PNGImage in pdf downloaded file

const getMultipleOrderNumbers = async orderNumbers => {
    let yPosition = 10;
    let ordersRecord = [];

    for (let index = 0; index < orderNumbers.length; index++) {
        try {
            const realImage = await generateAndDownloadMultipleBarcodesInPDF(
                orderNumbers[index]
            );
            ordersRecord.push({
                realImage,
                position: yPosition
            });

            yPosition += 50;
        } catch (error) {
            console.log(error);
        }
    }

    const doc = new jsPDF("p", "mm", "a4");

    ordersRecord.forEach(order => {
        doc.addImage(order.realImage, "PNG", 10, order.position);
    });

    doc.save("items-barcode.pdf");
};

const generateAndDownloadMultipleBarcodesInPDF = orderNo => {
    let makeBase64Image = convertTextToBase64Barcode(orderNo);

    return convertBase64ToPNGImage(makeBase64Image);
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

export { getMultipleOrderNumbers };
