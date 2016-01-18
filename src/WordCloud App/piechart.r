library(plotrix) 
slices <- c(10, 12, 4, 16, 8) 
lbls <- c("Arts", "Business", "Computers","Education", "Health","Recreation","Shopping","Sports") 
pie3D(summary(hist_pred),labels=lbls,explode=0.1, main="User Interest Pie Chart")