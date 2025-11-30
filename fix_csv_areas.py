#!/usr/bin/env python3
"""
Script to fix CSV by extracting areas from addresses and ensuring city is Rajkot
"""

import csv
import re
import sys

# Common areas in Rajkot
KNOWN_AREAS = [
    'greenland chowkdi', 'greenland', 'chowkdi',
    'kothariya', 'kotharia',
    'vavdi',
    'madhapar',
    'mota mava', 'mota mava',
    'munjka',
    'mavdi',
    'rohidaspra', 'rohidaspura',
    'nalanda',
    'bharatvan',
    'krishna society',
    'vrundavan',
    'korat vadi',
    'kalawad',
    'kankot',
    'victoria gardens',
    'rushab vatika',
    'r.k. university',
    'varu pani',
    'christ college',
    'synergy hospital',
    'fnf fun and food',
    'dhanlaxmi pump',
    'real urban deck',
]

def extract_area_from_address(address, city):
    """
    Extract area from address string
    """
    if not address:
        return ''
    
    address_lower = address.lower()
    
    # If city column has area name (like "Kotharia"), use it
    if city and city.lower() != 'rajkot':
        # Check if it's a known area
        for area in KNOWN_AREAS:
            if area in city.lower():
                return city.strip()
    
    # Try to find area in address
    # Look for patterns like "Area Name, Rajkot" or "..., Area Name, Rajkot"
    # Split by comma and look for area names before "Rajkot"
    parts = [p.strip() for p in address.split(',')]
    
    # Find Rajkot position
    rajkot_index = -1
    for i, part in enumerate(parts):
        if 'rajkot' in part.lower():
            rajkot_index = i
            break
    
    # If Rajkot found, check the part before it
    if rajkot_index > 0:
        potential_area = parts[rajkot_index - 1].strip()
        # Check if it's a known area
        for area in KNOWN_AREAS:
            if area in potential_area.lower():
                # Capitalize properly
                words = potential_area.split()
                return ' '.join([w.capitalize() for w in words])
    
    # Try direct matching in address
    for area in KNOWN_AREAS:
        if area in address_lower:
            # Find the full area name from address
            pattern = r'\b' + re.escape(area) + r'\b'
            match = re.search(pattern, address_lower, re.IGNORECASE)
            if match:
                # Get surrounding context
                start = max(0, match.start() - 20)
                end = min(len(address), match.end() + 20)
                context = address[start:end]
                # Extract the area name (capitalize first letter of each word)
                area_match = re.search(r'\b([A-Za-z\s]+' + re.escape(area) + r'[A-Za-z\s]*)\b', context, re.IGNORECASE)
                if area_match:
                    area_name = area_match.group(1).strip()
                    # Clean up and capitalize
                    words = area_name.split()
                    return ' '.join([w.capitalize() for w in words])
                else:
                    # Just capitalize the area
                    return area.title()
    
    return ''

def fix_csv(input_file, output_file):
    """
    Fix CSV by extracting areas and ensuring city is Rajkot
    """
    rows = []
    
    with open(input_file, 'r', encoding='utf-8') as f:
        reader = csv.DictReader(f)
        fieldnames = reader.fieldnames
        
        # Add Area column if not exists
        if 'Area' not in fieldnames:
            fieldnames = list(fieldnames)
            # Insert Area after City
            city_index = fieldnames.index('City') if 'City' in fieldnames else len(fieldnames)
            fieldnames.insert(city_index + 1, 'Area')
        
        for row in reader:
            # Ensure city is Rajkot
            if 'City' in row:
                city = row['City'].strip()
                # If city is not Rajkot, extract area from it
                if city.lower() != 'rajkot':
                    area = extract_area_from_address(row.get('Full Address', ''), city)
                    row['Area'] = area
                    row['City'] = 'Rajkot'
                else:
                    # Extract area from address
                    area = extract_area_from_address(row.get('Full Address', ''), '')
                    row['Area'] = area
            else:
                row['Area'] = ''
                row['City'] = 'Rajkot'
            
            rows.append(row)
    
    # Write output
    with open(output_file, 'w', encoding='utf-8', newline='') as f:
        writer = csv.DictWriter(f, fieldnames=fieldnames)
        writer.writeheader()
        writer.writerows(rows)
    
    print(f"Fixed CSV saved to: {output_file}")
    print(f"Total rows processed: {len(rows)}")

if __name__ == '__main__':
    input_file = '/Users/techverito/Downloads/party_plot_cleaned.csv'
    output_file = '/Users/techverito/Downloads/party_plot_fixed_with_areas.csv'
    
    if len(sys.argv) > 1:
        input_file = sys.argv[1]
    if len(sys.argv) > 2:
        output_file = sys.argv[2]
    
    fix_csv(input_file, output_file)

