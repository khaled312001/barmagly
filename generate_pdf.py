from reportlab.lib import colors
from reportlab.lib.pagesizes import A4
from reportlab.platypus import SimpleDocTemplate, Table, TableStyle, Paragraph, Spacer
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.enums import TA_CENTER, TA_LEFT

# 1. Setup the PDF Filename
filename = "Barmagly_Services_Price_List.pdf"
doc = SimpleDocTemplate(filename, pagesize=A4, rightMargin=30, leftMargin=30, topMargin=30, bottomMargin=30)

# 2. Define Brand Colors (Neon Theme)
DARK_BG = colors.HexColor("#050A14")
NEON_CYAN = colors.HexColor("#00E5FF")
NEON_PURPLE = colors.HexColor("#BD00FF")
WHITE_TEXT = colors.HexColor("#FFFFFF")
GREY_TEXT = colors.HexColor("#CCCCCC")

# 3. Create Custom Styles
styles = getSampleStyleSheet()

# Title Style
title_style = ParagraphStyle(
    'NeonTitle',
    parent=styles['Title'],
    fontName='Helvetica-Bold',
    fontSize=28,
    textColor=NEON_CYAN,
    alignment=TA_CENTER,
    spaceAfter=10
)

# Subtitle Style
subtitle_style = ParagraphStyle(
    'NeonSubtitle',
    parent=styles['Normal'],
    fontName='Helvetica',
    fontSize=14,
    textColor=NEON_PURPLE,
    alignment=TA_CENTER,
    spaceAfter=30
)

# Section Header Style
header_style = ParagraphStyle(
    'SectionHeader',
    parent=styles['Heading2'],
    fontName='Helvetica-Bold',
    fontSize=16,
    textColor=WHITE_TEXT,
    backColor=colors.HexColor("#1A202C"),
    borderPadding=8,
    spaceBefore=15,
    spaceAfter=10
)

# 4. Content Data (Services)
elements = []

# -- Header Section --
elements.append(Paragraph("BARMAGLY", title_style))
elements.append(Paragraph("Innovative Tech Solutions | +201010254819", subtitle_style))
elements.append(Spacer(1, 20))

# -- Partnership Banner Text --
partnership_text = ParagraphStyle('Partnership', parent=styles['Normal'], textColor=WHITE_TEXT, alignment=TA_CENTER, fontSize=12)
elements.append(Paragraph("In Strategic Partnership with <b>JOVERO Marketing Agency</b>", partnership_text))
elements.append(Spacer(1, 20))

# -- Function to create a styled table --
def create_service_table(data):
    # Table Data
    t = Table(data, colWidths=[350, 150])
    
    # Table Style
    style = TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), NEON_PURPLE), # Header Row BG
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.white), # Header Row Text
        ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
        ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
        ('FONTSIZE', (0, 0), (-1, 0), 12),
        ('BOTTOMPADDING', (0, 0), (-1, 0), 10),
        ('BACKGROUND', (0, 1), (-1, -1), colors.HexColor("#111625")), # Body BG
        ('TEXTCOLOR', (0, 1), (-1, -1), colors.white), # Body Text
        ('GRID', (0, 0), (-1, -1), 0.5, colors.grey),
        ('VALIGN', (0, 0), (-1, -1), 'MIDDLE'),
        ('PADDING', (0, 0), (-1, -1), 10),
    ])
    t.setStyle(style)
    return t

# -- Section 1: Development Solutions --
elements.append(Paragraph("Development Solutions", header_style))
data_dev = [
    ["Service", "Price Range"],
    ["E-Learning Platform (LMS) for Academies", "Contact for Quote"],
    ["Medical Center Management System", "Contact for Quote"],
    ["Restaurant POS & ERP System", "Contact for Quote"],
    ["Corporate Website Design", "Starting from $XXX"],
    ["E-Commerce Store (Web & App)", "Starting from $XXX"],
]
elements.append(create_service_table(data_dev))

# -- Section 2: Marketing Solutions (Jovero) --
elements.append(Paragraph("Marketing Solutions (Powered by Jovero)", header_style))
data_mkt = [
    ["Service Package", "Price Range"],
    ["Social Media Management (Monthly)", "Starting from $XXX"],
    ["SEO & Search Engine Optimization", "Starting from $XXX"],
    ["Brand Identity Design", "Starting from $XXX"],
    ["Sponsored Ads Campaigns", "Based on Budget"],
]
elements.append(create_service_table(data_mkt))

# -- Footer --
elements.append(Spacer(1, 40))
footer_style = ParagraphStyle('Footer', parent=styles['Normal'], textColor=NEON_CYAN, alignment=TA_CENTER, fontSize=10)
elements.append(Paragraph("www.barmagly.tech | info@barmagly.tech", footer_style))

# 5. Build PDF
# Note: Since we want a dark background for the whole page, we need a custom canvas or just accept white margins.
# For simplicity in this script, the tables have dark backgrounds.
doc.build(elements)

print(f"PDF '{filename}' generated successfully.")
