import pyreadstat
import json
import spss_converter
import sys

file_name = sys.argv[1]

dataMatrix = json.loads(spss_converter.to_json(file_name, layout = 'records'))
meta = spss_converter.get_metadata(file_name)

data = {}

data['dataMatrix'] = dataMatrix
data['variables'] = []

for value in meta.column_metadata.values():
    value = value.to_dict()
    entry = {
        'name': value['name'],
        'label': value['label'],
    }
    values = []
    if value['value_metadata']:
        for val in value['value_metadata']:
            values.append({
                'value': val,
                'label': value['value_metadata'][val]
            })
        entry['values'] = values
        data['variables'].append(entry)

    entry['missingFormat'] = ''
    entry['missingVal1'] = ''
    entry['missingVal2'] = ''
    entry['missingVal3'] = ''

    if value['missing_range_metadata']:
        if len(value['missing_range_metadata']) == 1:
            entry['missingFormat'] = 'SPSS_ONE_MISSVAL'
        elif len(value['missing_range_metadata']) == 2:
            entry['missingFormat'] = 'SPSS_TWO_MISSVAL'
        elif len(value['missing_range_metadata']) == 3:
            entry['missingFormat'] = 'SPSS_THREE_MISSVAL'

        for i, missing in enumerate(value['missing_range_metadata']):
            entry['missingVal'+str(i+1)] = missing['high']

print(json.dumps(data, indent=2))
