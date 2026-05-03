<style>
    .receipt-container * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @page {
        margin: 0.5cm;
        size: auto;
    }

    .receipt-container {
        font-family: 'DejaVu Sans', sans-serif;
        background: #fff;
        color: #333;
        font-size: 13px;
        line-height: 1.4;
    }

    .receipt-container .receipt-wrapper {
        max-width: 680px;
        margin: 0 auto;
        padding: 30px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        page-break-inside: avoid;
    }

    .receipt-container .header {
        text-align: center;
        border-bottom: 2px solid #875233;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .receipt-container .header h1 {
        font-size: 22px;
        color: #875233;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .receipt-container .header p {
        font-size: 12px;
        color: #888;
        margin-top: 4px;
    }

    .receipt-container .paid-stamp {
        text-align: center;
        margin-bottom: 20px;
    }

    .receipt-container .paid-stamp span {
        display: inline-block;
        border: 3px solid #16a34a;
        color: #16a34a;
        font-size: 28px;
        font-weight: 900;
        padding: 6px 28px;
        border-radius: 8px;
        letter-spacing: 6px;
        transform: rotate(-4deg);
        opacity: 0.85;
    }

    .receipt-container .section-title {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #875233;
        font-weight: 700;
        margin-bottom: 8px;
        border-bottom: 1px solid #f0e8e2;
        padding-bottom: 4px;
    }

    .receipt-container .detail-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .receipt-container .detail-table tr td {
        padding: 7px 6px;
        border-bottom: 1px solid #f5f5f5;
    }

    .receipt-container .detail-table tr td:first-child {
        font-weight: 600;
        width: 45%;
        color: #555;
    }

    .receipt-container .detail-table tr td:last-child {
        color: #222;
    }

    .receipt-container .amount-box {
        background: #fdf4ef;
        border-left: 4px solid #875233;
        border-radius: 6px;
        padding: 12px 18px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .receipt-container .amount-box .label {
        font-size: 12px;
        color: #875233;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .receipt-container .amount-box .value {
        font-size: 22px;
        font-weight: 700;
        color: #875233;
    }

    .receipt-container .footer {
        text-align: center;
        font-size: 11px;
        color: #aaa;
        margin-top: 15px;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
    }

    .receipt-container .footer strong {
        color: #875233;
    }
</style>