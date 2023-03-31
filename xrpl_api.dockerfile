FROM python:3.8-slim

WORKDIR /app/
ADD requirements.txt /app/

RUN apt update -y
RUN apt install zip unzip wget htop nano git curl iputils-ping -y
RUN pip install -r requirements.txt

ADD . /app/

EXPOSE 8005

CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000", "--reload"]