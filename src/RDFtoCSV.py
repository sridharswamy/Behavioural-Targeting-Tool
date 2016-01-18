class RDF:
    
    def __init__(self, filename=''):
        self.in_filename = filename
        self.fd = open(filename,'r')
        self.urls_serial = 0
        self.read_urls = []
        self.topics = {}
        self.titles = {}
        
    def __enter__(self):
        return self

    def __exit__(self, type, value, traceback):
        self.fd.close()

    def add_url(self, url='', title='', topic='', lower=True):
        topic = topic.split('_')[0]
        url = url.replace(',','')
        if lower:
            url = url.lower()
        ignored_topics = ['World', 'Regional']
        if not topic in ignored_topics:
            self.urls_serial += 1
            self.read_urls.append([self.urls_serial, str(url), str(topic),str(title)])
            if topic in self.topics:
                self.topics[topic] += 1
            else:
               self.topics[topic] = 1

    def showTopics(self):
        for topic in self.topics:
            print topic, ':', str(self.topics[topic])

    def getPageURL(self, line=''):
        return line.split('"')[1] 

    def getPageTopic(self):
        topic = ''
        for line in self.fd:
            line = line.strip()
            if line.startswith('<topic'):
                topic = line.rsplit('<',1)[0].split('/')[1]
            elif line.startswith('</ExternalPage'):
                return topic      

    def getPageTitle(self):
        title = ''
        for line in self.fd:
            line = line.strip()
            if line.startswith('<d:Title'):
                title = line.rsplit('<',1)[0].split('>')[1]
            elif line.startswith('</ExternalPage'):
                return title	

    def getPages(self):
        for line in self.fd:
            line = line.strip()
            if line.startswith('<ExternalPage'):
                url = self.getPageURL(line)
                title=self.getPageTitle()
                topic = self.getPageTopic()              
                self.add_url(url, topic ,title)
        print 'Read URLs:', len(self.read_urls), '\n'

    def writeCSV(self):
        csv_finename = 'newest1.csv'
        fd = open(csv_finename, 'w')
        for u in self.read_urls:
            line = '%d,%s,%s,%s\n' % tuple(u)
            fd.write(line)
        fd.close()

def main(filename=''):
    with RDF(filename) as rdf:
        rdf.getPages()
        rdf.writeCSV()
        
if __name__ == '__main__':
    main(filename='content.rdf.u8')
