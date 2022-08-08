FROM openjdk:11

COPY .github/workflows/manifests/libs/spss_lib/spss-1.0.0.RELEASE.jar app.jar
COPY .github/workflows/manifests/libs/spss_lib/native /home/datawiz/spss_webservice/native/

RUN mkdir /home/datawiz/spss_webservice/tmp/

EXPOSE "8081"

ENTRYPOINT ["java","-jar","/app.jar"]