import pandas as pd
import plotly.express as px
from sklearn.ensemble import IsolationForest

dataset = pd.read_csv('http://127.0.0.1:8000/anomalies/download/4007', parse_dates=[0])

datetime_series = pd.to_datetime(dataset['period_date'])
datetime_index = pd.DatetimeIndex(datetime_series.values)
period_index = pd.PeriodIndex(datetime_index, freq='M')
dataset = dataset.set_index(period_index)
dataset.drop('period_date',axis=1,inplace=True)
dataset.head()

isf_dataset = dataset.copy()
clf = IsolationForest(max_samples='auto', contamination=0.01)
clf.fit(isf_dataset)
isf_dataset['Anomaly'] = clf.predict(isf_dataset)
anomalies = isf_dataset.query('Anomaly == -1')

df = pd.DataFrame(anomalies)

print(df)

df.to_csv(r'F:\Отчеты\collector\scripts\python\anomalies.csv', index=False, header=True)
