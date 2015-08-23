#!/usr/bin/env python
# -*- coding: utf-8 -*-

from flask import Flask, jsonify, request
from flask.json import JSONEncoder
import MySQLdb
import datetime
import calendar


class SpecializedJSONEncoder(JSONEncoder):
    def default(self, obj):
        if isinstance(obj, datetime.datetime):
            return calendar.timegm(obj.timetuple())
        elif isinstance(obj, datetime.date):
            return calendar.timegm(obj.timetuple())
        elif isinstance(obj, datetime.timedelta):
            return calendar.timegm((datetime.datetime.min + obj).timetuple())
        else:
            return super(SpecializedJSONEncoder, self).default(obj)

app = Flask(__name__)
app.json_encoder = SpecializedJSONEncoder
app.debug = True

@app.route("/")
def hello():
    return "living"
    
@app.route("/schedule")
def temp():

    date = request.args.get('date', "", type=str)

    #Если не передан параметр с датой
    if date == '':
        d = datetime.datetime.now()
        date = d.strftime("%Y-%m-%d")

    db = MySQLdb.connect(host="127.0.0.1", user='root', db='domru', charset='utf8')
    cur = db.cursor()
    query = "SELECT s.id,s.channel_id,s.title as tv_prog_title,s.is_catchup_available,s.duration,s.start, c.title as channel_title, c.epg_channel_id " \
            "FROM schedule s LEFT JOIN channel c ON s.channel_id = c.id WHERE start >= %s AND start <= %s ORDER BY c.id"
    param = (date + " 00:00:00", date + " 23:59:59")
    cur.execute(query, param)

    returnChannelsJsonArray = [] #Массив с программой для возврата клиенту
    thisScheduleElement = [] #Элемент
    last_channel_id = -1;
    for id,channel_id, tv_prog_title, is_catchup_available, duration, start, channel_title, epg_channel_id in cur.fetchall():
        if last_channel_id != channel_id:
            last_channel_id = channel_id
            thisScheduleElement = []
            thisScheduleElement.append({'channel_id' : channel_id, 'duration': duration,
                                  'title': tv_prog_title, 'is_catchup_available': is_catchup_available,
                                  'id': id, 'start': start})
            returnChannelsJsonArray.append({'id': channel_id, 'title': channel_title, 'epg_channel_id': epg_channel_id, 'schedule': thisScheduleElement})
        else:
             thisScheduleElement.append({'channel_id' : channel_id, 'duration': duration,
                                  'title': tv_prog_title, 'is_catchup_available': is_catchup_available,
                                  'id': id, 'start': start})



    return jsonify(channels = returnChannelsJsonArray)
    
if __name__ == "__main__":
    app.run()