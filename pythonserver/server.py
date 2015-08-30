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

    db = MySQLdb.connect(host="127.0.0.1", user='root',passwd='',db='domru', charset='utf8')
    cur = db.cursor()
    query = "SELECT * FROM (SELECT "\
            "        c.id, ss.channel_id, ss.title as tv_prog_title, ss.is_catchup_available, c.title as channel_title, c.epg_channel_id, "\
            "        IF(DATE(ss.start) < DATE(%s),  TIMESTAMPDIFF(SECOND,DATE(%s),ss.end) ,ss.duration) as duration,"\
            "        IF(DATE(ss.start) < DATE(%s),  DATE(%s) ,ss.start) as start,"\
            "        ss.end"\
            "    FROM"\
            "        ("\
            "            SELECT"\
            "                id,"\
            "                channel_id,"\
            "                title,"\
            "                is_catchup_available,"\
            "                duration,"\
            "                `start`,"\
            "                DATE_ADD("\
            "                    START,"\
            "                    INTERVAL s.duration SECOND"\
            "                )AS"\
            "            END"\
            "        FROM"\
            "            `schedule` s"\
            "        )ss"\
             "   LEFT JOIN channel c ON ss.channel_id = c.id"\
            "    WHERE"\
             "       (DATE(ss.start)= DATE(%s)"\
             "   OR DATE(ss. END)= DATE(%s)) "\
             "   ORDER BY c.id) WHERE duration > 0"

    param = (date,date,date,date,date,date)
    cur.execute(query, param)

    returnChannelsJsonArray = [] #Массив с программой для возврата клиенту
    thisScheduleElement = [] #Элемент
    last_channel_id = -1;
    for id,channel_id, tv_prog_title, is_catchup_available,  channel_title, epg_channel_id, duration, start, end in cur.fetchall():
        if last_channel_id != channel_id:
            last_channel_id = channel_id
            thisScheduleElement = []
            thisScheduleElement.append({'channel_id' : channel_id, 'duration': duration,
                                  'title': tv_prog_title, 'is_catchup_available': is_catchup_available,
                                  'id': id, 'start': start, 'end': end})
            returnChannelsJsonArray.append({'id': channel_id, 'title': channel_title, 'epg_channel_id': epg_channel_id, 'schedule': thisScheduleElement})
        else:
             thisScheduleElement.append({'channel_id' : channel_id, 'duration': duration,
                                  'title': tv_prog_title, 'is_catchup_available': is_catchup_available,
                                  'id': id, 'start': start, 'end': end})



    return jsonify(channels = returnChannelsJsonArray)
    
if __name__ == "__main__":
    app.run()